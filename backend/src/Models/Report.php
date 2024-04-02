<?php
namespace Models;
use Utils\Proxy;
class Report extends Model {
    private string $status;
    private string $reason;
    private $report_date;
    private $meme_id;
    private Proxy $user;
    /**
     * Create a new instance of Report
     * @param int $id
     * @param string $reason
     * @param string $report_date
     * @param int $meme_id
     * @param int $user_id
     * @param string $status
     */

    public function __construct($id, $reason, $report_date, $meme_id, $user_id, $status) {
        parent::__construct($id);
        $this->reason = $reason;
        $this->report_date = $report_date;
        $this->meme_id = $meme_id;
        $this->user= new Proxy($user_id, 'User');
        $this->status = $status;
    }
    /**
     * get the user id
     * @return int
     */
    public function getUserId(){
        return $this->user->getId();
    }
    /**
     * get the meme id
     * @return int
     */
    public function getMemeId(){
        return $this->meme_id;
    }
    /**
     * get the user instance
     * @return user
     */
    public function getUser(): User
    {
        return $this->user->getInstance();
    }
    /**
     * get the reason of the report
     * @return string
     */

    public function getReason() {
        return $this->reason;
    }

    /**
     * get the report date
     * @return string
     */
    public function getReportDate() {
        return $this->report_date;
    }
    /**
     * get the status of the report
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * encode the report as json
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