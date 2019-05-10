<?php
  namespace hbattat;
  use \DOMDocument;
  use \DOMXpath;
  /**
   *  Verifies email address by attempting to connect and check with the mail server of that account
   *
   *  Author: Sam Battat hbattat@msn.com
   *          http://github.com/hbattat
   *
   *  License: This code is released under the MIT Open Source License. (Feel free to do whatever)
   *
   *  Last update: Oct 11 2016
   *
   * @package VerifyEmail
   * @author  Husam (Sam) Battat <hbattat@msn.com>
   * This is a test message for packagist
   */

  class VerifyEmail {
    public $email;
    public $verifier_email;
    public $port;
    private $mx;
    private $connect;
    private $errors;
    private $debug;
    private $debug_raw;

    private $_yahoo_signup_page_url = 'https://login.yahoo.com/account/create?specId=yidReg&lang=en-US&src=&done=https%3A%2F%2Fwww.yahoo.com&display=login';
    private $_yahoo_signup_ajax_url = 'https://login.yahoo.com/account/module/create?validateField=yid';
    private $_yahoo_domains = array('yahoo.com',"yahoo.co.in");
    private $_hotmail_signin_page_url = 'https://login.live.com/';
    private $_hotmail_username_check_url = 'https://login.live.com/GetCredentialType.srf?wa=wsignin1.0';
    private $_hotmail_domains = array('hotmail.com', 'live.com', 'outlook.com', 'msn.com');
    private $_mail_com_signup_page_url = 'https://signup.mail.com/';
    private $_mail_com_username_check_url = 'https://onereg-email-suggest.mail.com/email-alias/availability';
    private $_mail_com_domains = array('mail.com', 'email.com', 'usa.com', 'myself.com', 'consultant.com', 'post.com', 'europe.com', 'asia.com', 'iname.com', 'writeme.com', 'dr.com', 'engineer.com', 'cheerful.com', 'accountant.com', 'techie.com', 'linuxmail.org', 'uymail.com', 'contractor.net', 'accountant.com', 'activist.com', 'adexec.com', 'allergist.com', 'alumni.com', 'alumnidirector.com', 'angelic.com', 'appraiser.net', 'archaeologist.com', 'arcticmail.com', 'artlover.com', 'asia.com', 'auctioneer.net', 'bartender.net', 'bikerider.com', 'birdlover.com', 'brew-meister.com', 'cash4u.com', 'chef.net', 'chemist.com', 'clerk.com', 'clubmember.org', 'collector.org', 'columnist.com', 'comic.com', 'computer4u.com', 'consultant.com', 'contractor.net', 'coolsite.net', 'counsellor.com', 'cyberservices.com', 'deliveryman.com', 'diplomats.com', 'disposable.com', 'dr.com', 'engineer.com', 'execs.com', 'fastservice.com', 'financier.com', 'fireman.net', 'gardener.com', 'geologist.com', 'graduate.org', 'graphic-designer.com', 'groupmail.com', 'hairdresser.net', 'homemail.com', 'hot-shot.com', 'instruction.com', 'instructor.net', 'insurer.com', 'job4u.com', 'journalist.com', 'legislator.com', 'lobbyist.com', 'minister.com', 'musician.org', 'myself.com', 'net-shopping.com', 'optician.com', 'orthodontist.net', 'pediatrician.com', 'photographer.net', 'physicist.net', 'planetmail.com', 'planetmail.net', 'politician.com', 'post.com', 'presidency.com', 'priest.com', 'programmer.net', 'publicist.com', 'qualityservice.com', 'radiologist.net', 'realtyagent.com', 'registerednurses.com', 'repairman.com', 'representative.com', 'rescueteam.com', 'salesperson.net', 'secretary.net', 'socialworker.net', 'sociologist.com', 'solution4u.com', 'songwriter.net', 'surgical.net', 'teachers.org', 'tech-center.com', 'techie.com', 'technologist.com', 'theplate.com', 'therapist.net', 'toothfairy.com', 'tvstar.com', 'umpire.com', 'webname.com', 'worker.com', 'workmail.com', 'writeme.com', '2trom.com', 'activist.com', 'aircraftmail.com', 'artlover.com', 'atheist.com', 'bikerider.com', 'birdlover.com', 'blader.com', 'boardermail.com', 'brew-master.com', 'brew-meister.com', 'bsdmail.com', 'catlover.com', 'chef.net', 'clubmember.org', 'collector.org', 'cutey.com', 'dbzmail.com', 'doglover.com', 'doramail.com', 'galaxyhit.com', 'gardener.com', 'greenmail.net', 'hackermail.com', 'hilarious.com', 'keromail.com', 'kittymail.com', 'linuxmail.org', 'lovecat.com', 'marchmail.com', 'musician.org', 'nonpartisan.com', 'petlover.com', 'photographer.net', 'snakebite.com', 'songwriter.net', 'techie.com', 'theplate.com', 'toke.com', 'uymail.com', 'computer4u.com', 'consultant.com', 'contractor.net', 'coolsite.net', 'cyberdude.com', 'cybergal.com', 'cyberservices.com', 'cyber-wizard.com', 'engineer.com', 'fastservice.com', 'graphic-designer.com', 'groupmail.com', 'homemail.com', 'hot-shot.com', 'housemail.com', 'humanoid.net', 'iname.com', 'inorbit.com', 'mail-me.com', 'myself.com', 'net-shopping.com', 'null.net', 'physicist.net', 'planetmail.com', 'planetmail.net', 'post.com', 'programmer.net', 'qualityservice.com', 'rocketship.com', 'solution4u.com', 'tech-center.com', 'techie.com', 'technologist.com', 'webname.com', 'workmail.com', 'writeme.com', 'acdcfan.com', 'angelic.com', 'artlover.com', 'atheist.com', 'chemist.com', 'diplomats.com', 'discofan.com', 'elvisfan.com', 'execs.com', 'hiphopfan.com', 'housemail.com', 'kissfans.com', 'madonnafan.com', 'metalfan.com', 'minister.com', 'musician.org', 'ninfan.com', 'ravemail.com', 'reborn.com', 'reggaefan.com', 'snakebite.com', 'songwriter.net', 'bellair.net', 'californiamail.com', 'dallasmail.com', 'nycmail.com', 'pacific-ocean.com', 'pacificwest.com', 'sanfranmail.com', 'usa.com', 'africamail.com', 'arcticmail.com', 'asia.com', 'asia-mail.com', 'australiamail.com', 'berlin.com', 'brazilmail.com', 'chinamail.com', 'dublin.com', 'dutchmail.com', 'englandmail.com', 'europe.com', 'europemail.com', 'germanymail.com', 'irelandmail.com', 'israelmail.com', 'italymail.com', 'koreamail.com', 'mexicomail.com', 'moscowmail.com', 'munich.com', 'polandmail.com', 'safrica.com', 'samerica.com', 'scotlandmail.com', 'spainmail.com', 'swedenmail.com', 'swissmail.com', 'torontomail.com', 'angelic.com', 'atheist.com', 'disciples.com', 'innocent.com', 'minister.com', 'muslim.com', 'priest.com', 'protestant.com', 'reborn.com', 'reincarnate.com', 'religious.com', 'saintly.com');
    private $page_content;
    private $page_headers;

    public function __construct($email = null, $verifier_email = null, $port = 25){
      $this->debug = array();
      $this->debug_raw = array();
      if(!is_null($email) && !is_null($verifier_email)) {
        $this->debug[] = 'Initialized with Email: '.$email.', Verifier Email: '.$verifier_email.', Port: '.$port;
        $this->set_email($email);
        $this->set_verifier_email($verifier_email);
      }
      else {
        $this->debug[] = 'Initialized with no email or verifier email values';
      }
      $this->set_port($port);
    }


    public function set_verifier_email($email) {
      $this->verifier_email = $email;
      $this->debug[] = 'Verifier Email was set to '.$email;
    }

    public function get_verifier_email() {
      return $this->verifier_email;
    }


    public function set_email($email) {
      $this->email = $email;
      $this->debug[] = 'Email was set to '.$email;
    }

    public function get_email() {
      return $this->email;
    }

    public function set_port($port) {
      $this->port = $port;
      $this->debug[] = 'Port was set to '.$port;
    }

    public function get_port() {
      return $this->port;
    }

    public function get_errors(){
      return array('errors' => $this->errors);
    }

    public function get_debug($raw = false) {
      if($raw) {
        return $this->debug_raw;
      }
      else {
        return $this->debug;
      }
    }

    public function verify() {
      $this->debug[] = 'Verify function was called.';

      $is_valid = false;

      //check if this is a yahoo email
      $domain = $this->get_domain($this->email);
      if(in_array(strtolower($domain), $this->_yahoo_domains)) {
        $is_valid = $this->validate_yahoo();
      }
      else if(in_array(strtolower($domain), $this->_hotmail_domains)){
        $is_valid = $this->validate_hotmail();
      }
      else if(in_array(strtolower($domain), $this->_mail_com_domains)){
        $is_valid = $this->validate_mail_com();
      }
      //otherwise check the normal way
      else {
        //find mx
        $this->debug[] = 'Finding MX record...';
        $this->find_mx();

        if(!$this->mx) {
          $this->debug[] = 'No MX record was found.';
          $this->add_error('100', 'No suitable MX records found.');
          return $is_valid;
        }
        else {
          $this->debug[] = 'Found MX: '.$this->mx;
        }


        $this->debug[] = 'Connecting to the server...';
        $this->connect_mx();

        if(!$this->connect) {
          $this->debug[] = 'Connection to server failed.';
          $this->add_error('110', 'Could not connect to the server.');
          return $is_valid;
        }
        else {
          $this->debug[] = 'Connection to server was successful.';
        }


        $this->debug[] = 'Starting veriffication...';
        if(preg_match("/^220/i", $out = fgets($this->connect))){
          $this->debug[] = 'Got a 220 response. Sending HELO...';
          fputs ($this->connect , "HELO ".$this->get_domain($this->verifier_email)."\r\n");
          $out = fgets ($this->connect);
          $this->debug_raw['helo'] = $out;
          $this->debug[] = 'Response: '.$out;

          $this->debug[] = 'Sending MAIL FROM...';
          fputs ($this->connect , "MAIL FROM: <".$this->verifier_email.">\r\n");
          $from = fgets ($this->connect);
          $this->debug_raw['mail_from'] = $from;
          $this->debug[] = 'Response: '.$from;

          $this->debug[] = 'Sending RCPT TO...';
          fputs ($this->connect , "RCPT TO: <".$this->email.">\r\n");
          $to = fgets ($this->connect);
          $this->debug_raw['rcpt_to'] = $to;
          $this->debug[] = 'Response: '.$to;

          $this->debug[] = 'Sending QUIT...';
          $quit = fputs ($this->connect , "QUIT");
          $this->debug_raw['quit'] = $quit;
          fclose($this->connect);

          $this->debug[] = 'Looking for 250 response...';
          if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
            $this->debug[] = 'Not found! Email is invalid.';
            $is_valid = false;
          }
          else{
            $this->debug[] = 'Found! Email is valid.';
            $is_valid = true;
          }
        }
        else {
          $this->debug[] = 'Encountered an unknown response code.';
        }
      }

      return $is_valid;
    }

    private function get_domain($email) {
      $email_arr = explode('@', $email);
      $domain = array_slice($email_arr, -1);
      return $domain[0];
    }
    private function find_mx() {
      $domain = $this->get_domain($this->email);
      $mx_ip = false;
      // Trim [ and ] from beginning and end of domain string, respectively
      $domain = ltrim($domain, '[');
      $domain = rtrim($domain, ']');

      if( 'IPv6:' == substr($domain, 0, strlen('IPv6:')) ) {
        $domain = substr($domain, strlen('IPv6') + 1);
      }

      $mxhosts = array();
      if( filter_var($domain, FILTER_VALIDATE_IP) ) {
        $mx_ip = $domain;
      }
      else {
        getmxrr($domain, $mxhosts, $mxweight);
      }

      if(!empty($mxhosts) ) {
        $mx_ip = $mxhosts[array_search(min($mxweight), $mxweight)];
      }
      else {
        if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
          $record_a = dns_get_record($domain, DNS_A);
        }
        elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
          $record_a = dns_get_record($domain, DNS_AAAA);
        }

        if( !empty($record_a) ) {
          $mx_ip = $record_a[0]['ip'];
        }

      }

      $this->mx = $mx_ip;
    }


    private function connect_mx() {
      //connect
      $this->connect = @fsockopen($this->mx, $this->port);
    }

    private function add_error($code, $msg) {
      $this->errors[] = array('code' => $code, 'message' => $msg);
    }

    private function clear_errors() {
      $this->errors = array();
    }

    private function validate_yahoo() {
      $this->debug[] = 'Validating a yahoo email address...';
      $this->debug[] = 'Getting the sign up page content...';
      $this->fetch_page('yahoo');

      $cookies = $this->get_cookies();
      $fields = $this->get_fields();

      $this->debug[] = 'Adding the email to fields...';
      $fields['yid'] = str_replace('@yahoo.com', '', strtolower($this->email));
      
      $this->debug[] = 'Ready to submit the POST request to validate the email.';

      $response = $this->request_validation('yahoo', $cookies, $fields);
      
      $this->debug[] = 'Parsing the response...';
      $response_errors = json_decode($response, true)['errors'];

      $this->debug[] = 'Searching errors for exisiting username error...';
      foreach($response_errors as $err){
        if($err['name'] == 'yid' && $err['error'] == 'IDENTIFIER_EXISTS'){
          $this->debug[] = 'Found an error about exisiting email.';
          return true;
        }
      }
      return false;
    }

    private function validate_hotmail() {
      $this->debug[] = 'Validating a hotmail email address...';
      $this->debug[] = 'Getting the sign up page content...';
      $this->fetch_page('hotmail');
      $body_fields = $this->get_fields(true);

      $cookies = $this->get_cookies();

      $this->debug[] = 'Sending another request to get the needed cookies for validation...';
      $this->fetch_page('hotmail', implode(' ', $cookies));
      $cookies = $this->get_cookies();

      $this->debug[] = 'Preparing fields...';
      $fields = $this->prep_hotmail_fields($cookies);
      $fields['flowToken'] = $body_fields['PPFT'];

      $this->debug[] = 'Ready to submit the POST request to validate the email.';
      $response = $this->request_validation('hotmail', $cookies, $fields);

      $this->debug[] = 'Searching username error...';
      $json_response = json_decode($response, true);
      if(!$json_response['IfExistsResult']){
        $this->debug[] = 'Found existing user..';
        return true;
      }
      $this->debug[] = 'Did not find existing user..';
      return false;
    }

    private function validate_mail_com() {
      $this->debug[] = 'Validating a mail.com email address...';
      $this->debug[] = 'Getting the sign up page content...';
      $this->fetch_page('mail');

      $extra_headers = array();

      $this->debug[] = 'Getting the authorization headers...';
      if(preg_match('/"accessToken":"(.*?)".*?"clientCredentialGuid":"(.*?)"/', $this->page_content, $matches)){
        $this->debug[] = 'Found authorization headers...';
        $extra_headers[] = 'Authorization: Bearer '.$matches[1];
        $extra_headers[] = 'X-CCGUID: ' . $matches[2];
      }
      $cookies = $this->get_cookies();

      $this->debug[] = 'Preparing fields...';
      $fields = array();
      $fields['emailAddress'] = $this->email;
      $fields['requestedEmailAddressProduct'] = 'mailcomFree';
      $fields['countryCode'] = 'US';
      $fields['suggestionProducts'] = array('mailcomFree');
      $fields['maxResultCountPerProduct'] = 10;
      $fields['mdhMaxResultCount'] = 5;

      $this->debug[] = 'Ready to submit the POST request to validate the email.';
      $response = $this->request_validation('mail', $cookies, $fields, $extra_headers);

      $this->debug[] = 'Searching username error...';
      $json_response = json_decode($response, true);
      if(!$json_response['emailAddressAvailable']){
        $this->debug[] = 'Email address is not available, so it is it valid';
        return true;
      }
      $this->debug[] = 'Email address is available, so it is not valid.';
      return false;
    }

    private function fetch_page($service, $cookies = ''){
      if($cookies){
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: en\r\n" .
                      "Cookie: ".$cookies."\r\n"
          )
        );
        $context = stream_context_create($opts);
      }
      if($service == 'yahoo'){
        if($cookies){
          $this->page_content = file_get_contents($this->_yahoo_signup_page_url, false, $context);
        }
        else{
          $this->page_content = file_get_contents($this->_yahoo_signup_page_url);
        }
      }
      else if($service == 'hotmail'){
        if($cookies){
          $this->page_content = file_get_contents($this->_hotmail_signin_page_url, false, $context);
        }
        else{
          $this->page_content = file_get_contents($this->_hotmail_signin_page_url);
        }
      }
      else if($service == 'mail'){
        if($cookies){
          $this->page_content = file_get_contents($this->_mail_com_signup_page_url, false, $context);
        }
        else{
          $this->page_content = file_get_contents($this->_mail_com_signup_page_url);
        }
      }

      if($this->page_content === false){
        $this->debug[] = 'Could not read the sign up page.';
        $this->add_error('200', 'Cannot not load the sign up page.');
      }
      else{
        $this->debug[] = 'Sign up page content stored.';
        $this->debug[] = 'Getting headers...';
        $this->page_headers = $http_response_header;
        $this->debug[] = 'Sign up page headers stored.';
      }
    }

    private function get_cookies(){
      $this->debug[] = 'Attempting to get the cookies from the sign up page...';
      if($this->page_content !== false){
        $this->debug[] = 'Extracting cookies from headers...';
        $cookies = array();
        foreach ($this->page_headers as $hdr) {
          if (preg_match('/^Set-Cookie:\s*(.*?;).*?$/i', $hdr, $matches)) {
            $cookies[] = $matches[1];
          }
        }

        if(count($cookies) > 0){
          $this->debug[] = 'Cookies found: '.implode(' ', $cookies);
          return $cookies;
        }
        else{
          $this->debug[] = 'Could not find any cookies.';
        }
      }
      return false;
    }

    private function get_fields($use_regex=false){
      $dom = new DOMDocument();
      $fields = array();
      if(@$dom->loadHTML($this->page_content)){
        $this->debug[] = 'Parsing the page for input fields...';
        $xp = new DOMXpath($dom);
        $nodes = $xp->query('//input');
        foreach($nodes as $node){
          $fields[$node->getAttribute('name')] = $node->getAttribute('value');
        }

        $this->debug[] = 'Extracted fields.';
      }
      else{
        $this->debug[] = 'Something is worng with the page HTML.';
        $this->add_error('210', 'Could not load the dom HTML.');
      }
      if($use_regex){
        if(preg_match('/<input.*?name="(.*?)".*?value="(.*?)".*?\/>/i', $this->page_content, $matches)){
          $fields[$matches[1]] = $matches[2];
	}
      }
      return $fields;
    }

    private function request_validation($service, $cookies, $fields, $extra_headers=null){
      if($service == 'yahoo'){
        $headers = array();
        $headers[] = 'Origin: https://login.yahoo.com';
        $headers[] = 'X-Requested-With: XMLHttpRequest';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36';
        $headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
        $headers[] = 'Accept: */*';
        $headers[] = 'Referer: https://login.yahoo.com/account/create?specId=yidReg&lang=en-US&src=&done=https%3A%2F%2Fwww.yahoo.com&display=login';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: en-US,en;q=0.8,ar;q=0.6';
      
        $cookies_str = implode(' ', $cookies);
        $headers[] = 'Cookie: '.$cookies_str;


        $postdata = http_build_query($fields);

        $opts = array('http' =>
          array(
            'method'  => 'POST',
            'header'  => $headers,
            'content' => $postdata
          )
        );

        $context  = stream_context_create($opts);
        $result = file_get_contents($this->_yahoo_signup_ajax_url, false, $context);
      }
      else if($service == 'hotmail'){
        $headers = array();
        $headers[] = 'Origin: https://login.live.com';
        $headers[] = 'hpgid: 33';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
        $headers[] = 'Content-type: application/json; charset=UTF-8';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Referer: https://login.live.com';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: en-US,en;q=0.8,ar;q=0.6';

        $cookies_str = implode(' ', $cookies);
        $headers[] = 'Cookie: '.$cookies_str;

        $postdata = json_encode($fields);

        $opts = array('http' =>
          array(
            'method'  => 'POST',
            'header'  => $headers,
            'content' => $postdata
          )
        );

        $context  = stream_context_create($opts);
        $result = file_get_contents($this->_hotmail_username_check_url, false, $context);
      } else if($service == 'mail'){ 
        $headers = array();
        $headers[] = 'Origin: https://signup.mail.com';
        $headers[] = 'X-UI-APP: registration-app2/3.8.3';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
        $headers[] = 'Content-type: application/json; charset=UTF-8';
	$headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'Referer: https://signup.mail.com/';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: en-US,en;q=0.9';

        $cookies_str = implode(' ', $cookies);
        $headers[] = 'Cookie: '.$cookies_str;

        if($extra_headers){
	  $headers = array_merge($headers, $extra_headers);
	}

        $postdata = json_encode($fields);

        $opts = array('http' =>
          array(
            'method'  => 'POST',
            'header'  => $headers,
            'content' => $postdata
          )
        );

        $context  = stream_context_create($opts);
        $result = file_get_contents($this->_mail_com_username_check_url, false, $context);
      }
      return $result;
    }

    private function prep_hotmail_fields($cookies){
      $fields = array();
      foreach($cookies as $cookie){
        list($key, $val) = explode('=', $cookie, 2);
        if($key == 'uaid'){
          $fields['uaid'] = $val;
          break;
        }
      }
      $fields['username'] = strtolower($this->email);
      return $fields;
    }

  }
