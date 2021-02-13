<?php
namespace core\log;
class Log{

    private $fileName;
    private $message;

    /**
     * Log constructor.
     * @param $fileName
     * @param $message
     */
    public function __construct($fileName, $message)
    {
        $this->fileName = $fileName;
        $this->message = $message;

        $this->createLog();
    }

    private function createLog():void
    {
        if(!is_dir(LOGPATH)){
            mkdir(LOGPATH);
        }
        file_put_contents(LOGPATH.$this->fileName, $this->message, FILE_APPEND);

    }


}
