<?php
/**
 * @method Object Oriented PHP SDK for Infusionsoft
 * @CreatedBy Justin Morris on 09-10-08
 * @UpdatedBy Michael Fairchild
 * @Updated 10/26/2013
 * @iSDKVersion 1.8.5
 * @ApplicationVersion 1.29.x
 */

if (!function_exists('xmlrpc_encode_entitites')) {
    include("xmlrpc-3.0/lib/xmlrpc.inc");
}
class iSDKException extends Exception
{
}

class iSDK
{

    static private $handle;
    public $logname = '';
    public $loggingEnabled = 0;

    /**
     * @method cfgCon
     * @description Creates and tests the API Connection to the Application
     * @param $name - Application Name
     * @param string $key - API Key
     * @param string $dbOn - Error Handling On
     * @param string $type - Infusionsoft or Mortgage Pro
     * @return bool
     * @throws iSDKException
     */
    public function cfgCon($name, $key = "", $dbOn = "on", $type = "i")
    {
        $this->debug = (($key == 'on' || $key == 'off' || $key == 'kill' || $key == 'throw') ? $key : $dbOn);

        if ($key != "" && $key != "on" && $key != "off" && $key != 'kill' && $key != 'throw') {
            $this->key = $key;
        } else {
            include('conn.cfg.php');
            $appLines = $connInfo;
            foreach ($appLines as $appLine) {
                $details[substr($appLine, 0, strpos($appLine, ":"))] = explode(":", $appLine);
            }
            $appname = $details[$name][1];
            $type = $details[$name][2];
            $this->key = $details[$name][3];
        }

        switch ($type) {
            case 'm':
                $this->client = new xmlrpc_client("https://$appname.mortgageprocrm.com/api/xmlrpc");
                break;
            case 'i':
            default:
                if (!isset($appname)) {
                    $appname = $name;
                }
                $this->client = new xmlrpc_client("https://$appname.infusionsoft.com/api/xmlrpc");
                break;
        }

        /* Return Raw PHP Types */
        $this->client->return_type = "phpvals";

        /* SSL Certificate Verification */
        $this->client->setSSLVerifyPeer(false);
        $this->client->setCaCertificate((__DIR__ != '__DIR__' ? __DIR__ : dirname(__FILE__)) . '/infusionsoft.pem');
        //$this->client->setDebug(2);

        $this->encKey = php_xmlrpc_encode($this->key);

        /* Connection verification */

        try{
            $connected = $this->dsGetSetting("Application","enabled");

            if(strpos($connected, 'ERROR') !== FALSE){
                throw new iSDKException($connected);
            }

        }catch (iSDKException $e){
            throw new iSDKException($e->getMessage());
        }

        return true;
    }

    /**
     * @method getTemporaryKey
     * @description Connect and Obtain an API key from a vendor key
     * @param string $name - Application Name
     * @param string $user - Username
     * @param string $pass - Password
     * @param string $key - Vendor Key
     * @param string $dbOn - Error Handling On
     * @param string $type - Infusionsoft or Mortgage Pro
     * @return bool
     * @throws iSDKException
     */
    public function vendorCon($name, $user, $pass, $key = "", $dbOn = "on", $type = "i")
    {
        $this->debug = (($key == 'on' || $key == 'off' || $key == 'kill' || $key == 'throw') ? $key : $dbOn);

        if ($key != "" && $key != "on" && $key != "off" && $key != 'kill' && $key != 'throw') {
            if ($type == "i") {
                $this->client = new xmlrpc_client("https://$name.infusionsoft.com/api/xmlrpc");
            } else if ($type == "m") {
                $this->client = new xmlrpc_client("https://$name.mortgageprocrm.com/api/xmlrpc");
            } else {
                throw new iSDKException ("Invalid application type: \"$name\"");
            }
            $this->key = $key;
        } else {
            include('conn.cfg.php');
            $appLines = $connInfo;
            foreach ($appLines as $appLine) {
                $details[substr($appLine, 0, strpos($appLine, ":"))] = explode(":", $appLine);
            }
            if (!empty($details[$name])) {
                if ($details[$name][2] == "i") {
                    $this->client = new xmlrpc_client("https://" . $details[$name][1] .
                        ".infusionsoft.com/api/xmlrpc");
                } elseif ($details[$name][2] == "m") {
                    $this->client = new xmlrpc_client("https://" . $details[$name][1] .
                        ".mortgageprocrm.com/api/xmlrpc");
                } else {
                    throw new iSDKException("Invalid application name: \"" . $name . "\"");
                }
            } else {
                throw new iSDKException("Application Does Not Exist: \"" . $name . "\"");
            }
            $this->key = $details[$name][3];
        }

        /* Return Raw PHP Types */
        $this->client->return_type = "phpvals";

        /* SSL Certificate Verification */
        $this->client->setSSLVerifyPeer(TRUE);
        $this->client->setCaCertificate((__DIR__ != '__DIR__' ? __DIR__ : dirname(__FILE__)) . '/infusionsoft.pem');

        $carray = array(
            php_xmlrpc_encode($this->key),
            php_xmlrpc_encode($user),
            php_xmlrpc_encode(md5($pass)));

        $this->key = $this->methodCaller("DataService.getTemporaryKey", $carray);

        $this->encKey = php_xmlrpc_encode($this->key);

        try {
            $connected = $this->dsGetSetting("Application", "enabled");
        } catch (iSDKException $e) {
            throw new iSDKException("Connection Failed");
        }
        return TRUE;
    }

    /**
     * @method echo
     * @description Worthless public function, used to validate a connection
     * @param string $txt
     * @return int|mixed|string
     */
    public function appEcho($txt)
    {
        $carray = array(
            php_xmlrpc_encode($txt));

        return $this->methodCaller("DataService.echo", $carray);
    }

    /**
     * @method Method Caller
     * @description Builds XML and Sends the Call
     * @param string $service
     * @param array $callArray
     * @return int|mixed|string
     * @throws iSDKException
     */
    public function methodCaller($service, $callArray)
    {

        /* Set up the call */
        $call = new xmlrpcmsg($service, $callArray);

        if ($service != 'DataService.getTemporaryKey') {
            array_unshift($call->params, $this->encKey);
        }

        /* Send the call */
        $now = time();
        $start = microtime();
        $result = $this->client->send($call);

        $stop = microtime();
        /* Check the returned value to see if it was successful and return it */
        if (!$result->faultCode()) {
            if ($this->loggingEnabled == 1) {
                $this->log(array('Method' => $service, 'Call' => $callArray, 'Start' => $start, 'Stop' => $stop, 'Now' => $now, 'Result' => $result, 'Error' => 'No', 'ErrorCode' => 'No Error Code Received'));
            }
            return $result->value();
        } else {
            if ($this->loggingEnabled == 1) {
                $this->log(array('Method' => $service, 'Call' => $callArray, 'Start' => $start, 'Stop' => $stop, 'Now' => $now, 'Result' => $result, 'Error' => 'Yes', 'ErrorCode' => "ERROR: " . $result->faultCode() . " - " . $result->faultString()));
            }
            if ($this->debug == "kill") {
                die("ERROR: " . $result->faultCode() . " - " .
                    $result->faultString());
            } elseif ($this->debug == "on") {
                return "ERROR: " . $result->faultCode() . " - " .
                $result->faultString();
            } elseif ($this->debug == "throw") {
                throw new iSDKException($result->faultString(), $result->faultCode());
            } elseif ($this->debug == "off") {
                //ignore!
            }
        }

    }

    /**
     * @service Affiliate Program Service
     */

    /**
     * @method getAffiliatesByProgram
     * @description Gets a list of all of the affiliates with their contact data for the specified program.  This includes all of the custom fields defined for the contact and affiliate records that are retrieved.
     * @param int $programId
     * @return array
     */
    public function getAffiliatesByProgram($programId)
    {
        $carray = array(
            php_xmlrpc_encode((int)$programId));
        return $this->methodCaller("AffiliateProgramService.getAffiliatesByProgram", $carray);
    }

    /**
     * @method getProgramsForAffiliate
     * @description Gets a list of all of the Affiliate Programs for the Affiliate specified.
     * @param int $affiliateId
     * @return array
     */
    public function getProgramsForAffiliate($affiliateId)
    {
        $carray = array(

            php_xmlrpc_encode((int)$affiliateId));
        return $this->methodCaller("AffiliateProgramService.getProgramsForAffiliate", $carray);
    }

    /**
     * @method getAffiliatePrograms
     * @description Gets a list of all of the Affiliate Programs that are in the application.
     * @return int|mixed|string
     */
    public function getAffiliatePrograms()
    {
        $carray = array();
        return $this->methodCaller("AffiliateProgramService.getAffiliatePrograms", $carray);
    }

    /**
     * @method getResourcesForAffiliateProgram
     * @description Gets a list of all of the resources that are associated to the Affiliate Program specified.
     * @param int $programId
     * @return array
     */
    public function getResourcesForAffiliateProgram($programId)
    {
        $carray = array(

            php_xmlrpc_encode((int)$programId));
        return $this->methodCaller("AffiliateProgramService.getResourcesForAffiliateProgram", $carray);
    }

    /**
     * @service Affiliate Service
     */

    /**
     * @method affClawbacks
     * @description returns all clawbacks in a date range
     * @param int $affId
     * @param date $startDate
     * @param date $endDate
     * @return array
     */
    public function affClawbacks($affId, $startDate, $endDate)
    {
        $carray = array(

            php_xmlrpc_encode((int)$affId),
            php_xmlrpc_encode($startDate, array('auto_dates')),
            php_xmlrpc_encode($endDate, array('auto_dates')));
        return $this->methodCaller("APIAffiliateService.affClawbacks", $carray);
    }

    /**
     * @method affCommissions
     * @description returns all commissions in a date range
     * @param int $affId
     * @param date $startDate
     * @param date $endDate
     * @return array
     */
    public function affCommissions($affId, $startDate, $endDate)
    {
        $carray = array(

            php_xmlrpc_encode((int)$affId),
            php_xmlrpc_encode($startDate, array('auto_dates')),
            php_xmlrpc_encode($endDate, array('auto_dates')));
        return $this->methodCaller("APIAffiliateService.affCommissions", $carray);
    }

    /**
     * @method affPayouts
     * @description returns all affiliate payouts in a date range
     * @param int $affId
     * @param date $startDate
     * @param date $endDate
     * @return array
     */
    public function affPayouts($affId, $startDate, $endDate)
    {
        $carray = array(

            php_xmlrpc_encode((int)$affId),
            php_xmlrpc_encode($startDate, array('auto_dates')),
            php_xmlrpc_encode($endDate, array('auto_dates')));
        return $this->methodCaller("APIAffiliateService.affPayouts", $carray);
    }

    /**
     * @method affRunningTotals
     * @description Returns a list with each row representing a single affiliates totals represented by a map with key (one of the names above, and value being the total for that variable)
     * @param array $affList
     * @return array
     */
    public function affRunningTotals($affList)
    {
        $carray = array(

            php_xmlrpc_encode($affList));
        return $this->methodCaller("APIAffiliateService.affRunningTotals", $carray);
    }

    /**
     * @method affSummary
     * @description returns how much the specified affiliates are owed
     * @param array $affList
     * @param date $startDate
     * @param date $endDate
     * @return array
     */
    public function affSummary($affList, $startDate, $endDate)
    {
        $carray = array(

            php_xmlrpc_encode($affList),
            php_xmlrpc_encode($startDate, array('auto_dates')),
            php_xmlrpc_encode($endDate, array('auto_dates')));
        return $this->methodCaller("APIAffiliateService.affSummary", $carray);
    }

    /**
     * @method getRedirectLinksForAffiliate
     * @description returns redirect links for affiliate specified
     * @param $affiliateId
     * @return int|mixed|string
     */
    public function getRedirectLinksForAffiliate($affiliateId)
    {
        $carray = array(

            php_xmlrpc_encode((int)$affiliateId));
        return $this->methodCaller("AffiliateService.getRedirectLinksForAffiliate", $carray);
    }

    /**
     * @service Contact Service
     */

    /**
     * @method add
     * @description add Contact to Infusionsoft (no duplicate checking)
     * @param array $cMap
     * @param string $optReason
     * @return int
     */
    public function addCon($cMap, $optReason = "")
    {

        $carray = array(

            php_xmlrpc_encode($cMap, array('auto_dates')));
        $conID = $this->methodCaller("ContactService.add", $carray);
        if (!empty($cMap['Email'])) {
            if ($optReason == "") {
                $this->optIn($cMap['Email']);
            } else {
                $this->optIn($cMap['Email'], $optReason);
            }
        }
        return $conID;
    }

    /**
     * @method update
     * @description Update an existing contact
     * @param int $cid
     * @param array $cMap
     * @return int
     */
    public function updateCon($cid, $cMap)
    {

        $carray = array(

            php_xmlrpc_encode((int)$cid),
            php_xmlrpc_encode($cMap, array('auto_dates')));
        return $this->methodCaller("ContactService.update", $carray);
    }

    /**
     * @method merge
     * @description Merge 2 contacts
     * @param int $cid
     * @param int $dcid
     * @return int
     */
    public function mergeCon($cid, $dcid)
    {
        $carray = array(

            php_xmlrpc_encode($cid),
            php_xmlrpc_encode($dcid));

        return $this->methodCaller("ContactService.merge", $carray);
    }

    /**
     * @method findbyEmail
     * @description finds all contact with an email address
     * @param string $eml
     * @param array $fMap
     * @return array
     */
    public function findByEmail($eml, $fMap)
    {

        $carray = array(

            php_xmlrpc_encode($eml),
            php_xmlrpc_encode($fMap));
        return $this->methodCaller("ContactService.findByEmail", $carray);
    }

    /**
     * @method load
     * @description Loads a contacts data
     * @param int $cid
     * @param array $rFields
     * @return array
     */
    public function loadCon($cid, $rFields)
    {

        $carray = array(

            php_xmlrpc_encode((int)$cid),
            php_xmlrpc_encode($rFields));
        return $this->methodCaller("ContactService.load", $carray);
    }

    /**
     * @method addToGroup
     * @description Apply a Tag to a Contact
     * @param int $cid