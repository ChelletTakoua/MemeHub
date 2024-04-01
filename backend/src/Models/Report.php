<?php
namespace Models;
use Utils\Proxy;
class Report extends Model {
    private string $status;
    private string $reason;
    private $report_date;
    private Proxy $meme;
    private Proxy $user;


    public function __construct($id, $reason, $report_date, $meme_id, $user_id, $status) {
        parent::__construct($id);
        $this->reason = $reason;
        $this->report_date = $report_date;
        $this->meme = new Proxy($meme_id, 'Meme');
        $this->user= new Proxy($user_id, 'User');
        $this->status = $status;
    }
    public function getUserId(){
        return $this->user->getId();
    }
    public function getMemeId(){
        return $this->meme->getId();
    }
    public function getUser(): Model
    {
        return $this->user->getInstance();
    }
    public function getMeme(): Model
    {
        return $this->meme->getInstance();
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
            'meme' => $this->meme,
            'user' => $this->user,
            'status' => $this->status
        ];
    }
   
}