<?php
namespace Models;
use Utils\Proxy;
class Report extends Model {
    private $reason;
    private $report_date;
    private $meme;
    private $user;

    public function __construct($id, $reason, $report_date, $meme_id, $user_id) {
        parent::__construct($id);
        $this->reason = $reason;
        $this->report_date = $report_date;
        $this->meme = new Proxy($meme_id, 'Meme');
        $this->user= new Proxy($user_id, 'User');
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
        return $this->report_date;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function setReportDate($report_date) {
        $this->report_date = $report_date;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'reason' => $this->reason,
            'report_date' => $this->report_date,
            'meme' => $this->meme,
            'user' => $this->user,
        ];
    }
   
}