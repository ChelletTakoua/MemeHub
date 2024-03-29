<?php
namespace Models;
use Utils\Proxy;
class BlockedMeme extends Model {
    private $meme;
    private $admin;
    private $report;

    public function __construct($id, $meme_id, $admin_id, $report_id) {
        $this->id = $id;
        $meme = new Proxy($meme_id, 'Meme');
        $admin = new Proxy($user_id, 'User');
        $report = new Proxy($report_id, 'Report');
    }

    public function getAdminId(){
        return $this->user->getId();
    }
    public function getMemeId(){
        return $this->meme->getId();
    }
    public function getAdmin(){ 
        return $this->user->getInstance();
    }
    public function getMeme(){ 
        return $this->meme->getInstance();
    }
    public function getReport(){ 
        return $this->report->getInstance();
    }
    public function getReportId(){
        return $this->report->getId();
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'meme' => $this->meme,
            'admin' => $this->admin,
            'report' => $this->report,
        ];
    }
    

}