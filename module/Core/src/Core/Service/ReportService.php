<?php
namespace Core\Service;

use \Douglas\Request\Report as Report;
use \Douglas\Request\Asset as Asset;

class ReportService extends BaseService
{
    private $config;

    private $jasperServer;
    private $jasperReportFile;
    private $jasperParam;
    private $outputFile;
    private $jasperFormat;
    private $jasperForceDownload;

    public function prepare($module ,$file, $param, $outputFile, $format = 'pdf', $download = true)
    {
        $this->config           = $this->getServiceManager()->get('Config');
        $this->jasperServer     = 'http://'.$this->config["reports"]["jasperuser"].':'.$this->config["reports"]["jasperpass"].'@'.$this->config["reports"]["jasperurl"];
        $this->jasperReportFile = $this->config["reports"]["jasperfoldermodule"][$module]. $file;

        $this->jasperParam      = $param;
        $this->outputFile       = $outputFile;
        $this->jasperFormat     = Report::getFormat($format);
        $this->jasperForceDownload = $download;

        return $this;
    }

    public function export()
    {
        $report = new Report(
            array(
                'jasper_url' => $this->jasperServer,
                'report_url' => $this->jasperReportFile,
                'parameters' => $this->jasperParam,
                'format'     => $this->jasperFormat,
            )
        );

        $fileName = "{$this->outputFile}.{$this->jasperFormat}";
        $report->send();

        if ($report->getError()) {
            // Check to see if the request was successful or not
            // and do something nice with the error
        }

        $body = $report->getBody();

        $forceDownload = $this->jasperForceDownload;

        if ($forceDownload) {
            header("Content-Type: application/force-download");
        } else {
            header('Content-type: application/pdf'); 
        }
        
        header("Pragma: public"); 
        header("Content-disposition: inline; filename=".$fileName."");
        print($body);
    }
}