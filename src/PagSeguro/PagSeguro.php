<?php

namespace Allfa\PagSeguro;
use PagSeguro\Configuration\Configure;
use phpDocumentor\Reflection\Types\Integer;
use Psr\Log\LoggerInterface as Log;
class PagSeguro
{
	/**
     * Log instance.
     *
     * @var object
     */
    protected $log;

	
	/**
     * Modo sandbox.
     *
     * @var bool
     */
    protected $sandbox;
	protected $email;
	protected $token;
	protected $notificationURL;
	 public function __construct(Log $log)
    {
        try {
            \PagSeguro\Library::initialize();
        } catch (\Exception $e) {

        }
        $this->log = $log;
        $this->setEnvironment();
    }
	
	/**
     * Define o ambiente de trabalho.
     */
    private function setEnvironment()
    {
		$this->sandbox = config('pagseguro.sandbox', env('PAGSEGURO_SANDBOX', true));
		$this->email = config('pagseguro.email', env('PAGSEGURO_EMAIL', ''));
        $this->token = config('pagseguro.token', env('PAGSEGURO_TOKEN', ''));
        $this->notificationURL = config('pagseguro.notificationURL', env('PAGSEGURO_NOTIFICATION', ''));
        //configure static method
		Configure::setEnvironment($this->sandbox?'sandbox':'production');
		Configure::setAccountCredentials($this->email, $this->token);
		//\PagSeguro\Configuration\Configure::setNotificationURL($this->notificationURL);
		Configure::setCharSet('ISO-8859-1');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSession()
    {
        return \PagSeguro\Services\Session::create(
            self::getCredentials()
        );

    }
	public function getCredentials(){
        return Configure::getAccountCredentials();
    }
	public function getPaymentMethod(){
		return new \PagSeguro\Domains\Requests\Payment();
	}

    /**
     * @param $notificationCode
     * @param $notificationType
     * @return mixed
     * @throws \Exception
     */
    public function getNotification($notificationCode, $notificationType)
    {
        switch ($notificationType) {
            case 'preApproval':
                return \PagSeguro\Services\PreApproval\Notification::check(self::getCredentials());
            case 'transaction':
                return \PagSeguro\Services\Transactions\Notification::check(self::getCredentials());
            default:
                throw new \Exception("Tipo de noficicacao desconhecido '$notificationType'");
        }
    }
    public function getPreApprovalStatus($status){
        return PreApprovalStatus::$status();
    }
    public function getTransactionStatus($status){
        return new TransactionStatus::$status();
    }
}
	