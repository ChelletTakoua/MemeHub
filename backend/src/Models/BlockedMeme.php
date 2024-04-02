<?php
namespace Models;
use Utils\Proxy;
class BlockedMeme extends Model {
    private $meme;
    private $admin;
    private $report;
    /**
     * Create a new instance of BlockedMeme
     * @param int $id
     * @param int $meme_id
     * @param int $admin_id
     * @param int $report_id
     */
    public function __construct($id, $meme_id, $admin_id, $report_id) {
        parent::__construct($id);
        $this->meme = new Proxy($meme_id, 'Meme');
        $this->admin = new Proxy($admin_id, 'User');
        $this->report = new Proxy($report_id, 'Report');
    }
    /**
     * get the admin id
     * @return int
     */

    public function getAdminId(){
        return $this->admin->getId();
    }
    /**
     * get the meme id
     * @return int
     */
    public function getMemeId(){
        return $this->meme->getId();
    }
    /**
     * get the admin instance
     * @return user
     */
    public function getAdmin(){ 
        return $this->admin->getInstance();
    }
    /**
     * get the meme instance
     * @return meme
     */
    public function getMeme(){ 
        return $this->meme->getInstance();
    }
    /**
     * get the report instance
     * @return report
     */
    public function getReport(){ 
        return $this->report->getInstance();
    }
    /**
     * get the report id
     * @return int
     */
    public function getReportId(){
        return $this->report->getId();
    }
    /**
     * encode the BlockedMeme instance as json
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => parent::getId(),
            'meme' => $this->meme,
            'admin' => $this->admin,
            'report' => $this->report,
        ];
    }
    

}