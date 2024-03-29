<?php
namespace Models;
use Utils\Proxy;
class Report extends Model {
    private $reason;
    private $reportDate;
    private $meme;
    private $user;

    public function __construct($id, $reason, $reportDate, $meme_id, $user_id) {
        $this->id = $id;
        $this->reason = $reason;
        $this->reportDate = $reportDate;
        $meme = new Proxy($meme_id, 'Meme');
        $user= new Proxy($user_id, 'User');
    }
    public function getUserId(){
        return $this->user->getId();
    }
    public function getMemeId(){
        return $this->meme->getId();
    }
    public function getUser(){ 
        return $this->user->getInstance();
    }
    public function getMeme(){ 
        return $this->meme->getInstance();
    }

    public function getReason() {
        return $this->reason;
    }

    public function getReportDate() {
        return $this->reportDate;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function setReportDate($reportDate) {
        $this->reportDate = $reportDate;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'reason' => $this->reason,
            'reportDate' => $this->reportDate,
            'meme' => $this->meme,
            'user' => $this->user,
        ];
    }
   
}