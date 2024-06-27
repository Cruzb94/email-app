<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Query\WhereQuery;
use Webklex\PHPIMAP\Message;


class EmailController extends Controller
{
    public function index() {

        $client = Client::account();
$client->connect();

//$messages = $client->query->all()->get();
$folders = $client->getFolders();

foreach($folders as $folder){

    //Get all Messages of the current Mailbox $folder
    /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
    $messages = $folder->messages()->all()->get();
    
    /** @var \Webklex\PHPIMAP\Message $message */
    foreach($messages as $message){
        echo $message->getSubject().'<br />';
        echo 'Attachments: '.$message->getAttachments()->count().'<br />';

        if($message->getAttachments()->count() > 0) {
            $attributes = $message->getAttachments()->getAttributes();

            print_r($attributes);
        }
        echo $message->getHTMLBody();
        
        //Move the current Message to 'INBOX.read'
       /* if($message->move('INBOX.read') == true){
            echo 'Message has ben moved';
        }else{
            echo 'Message could not be moved';
        } */
    }
}
       // dd( $folders);
    }
}
