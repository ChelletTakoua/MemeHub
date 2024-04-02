<?php
namespace Models;
use Utils\Proxy;
class Report extends Model {
    private string $status;
    private string $reason;
    private $report_date;
    private $meme_id;
    private Proxy $user;


    public function __construct($id, $reason, $report_date, $meme_id, $user_id, $status) {
        parent::__construct($id);
        $this->reason = $reason;
        $this->report_date = $report_date;
        $this->meme_id = $meme_id;
        $this->user= new Proxy($user_id, 'User');
        $this->status = $status;
    }
    public function getUserId(){
        return $this->user->getId();
    }
    public function getMemeId(){
        return $this->meme_id;
    }
    public function getUser(): Model
    {
        return $this->user->getInstance();
    }

    public function getReason() {
        return $this->reason;
    }

    public function getReportDate() {
        return $this->report_date;
    }

    public function getStatus() {
        return $this->status;
    }

    /**
     * @return array {id: , reason: , report_date: , meme: , user: }
     */

    public function jsonSerialize(): array
    {
        return [
            'id' => parent::getId(),
            'reason' => $this->reason,
            'report_date' => $this->report_date,
            'meme_id' => $this->meme_id,
            'user' => $this->user,
            'status' => $this->status
        ];
    }
   
}