<?php 
/**  
 *  
 *  
 *  
 * @class   orange_money_php_api
 * @author Bernard baudouin um
 * @link     
 * @version 1.0.2 
 */  

require_once 'core/Functions.php';
require_once 'api/MarchandPayment.php';
require_once 'api/CashoutBlance.php';
require_once 'api/TransactionStatus.php';
require_once 'configuration.php';


class OrangeMoneyApi{

    private $_data = [] ;
      
    public function __construct($_data_json)
    {
        $secured = new All_Funct();
        $_data_obj = json_decode($_data_json);
        $this->_data['referenceNumber'] = $secured->secure($_data_obj->referenceNumber, 'int');
        $this->_data['phone'] = $secured->secure($_data_obj->phone, 'int');
        $this->_data['amount'] = $secured->secure($_data_obj->amount, 'int');
        $this->_data['callback'] = $secured->is_empty($_data_obj->callback)? ORANGE_MONEY_NOTIFURL : $_data_obj->callback;
        $this->_data['description'] = $secured->is_empty($_data_obj->description)? ORANGE_MONEY_ORDER_DESC : $_data_obj->description;
        if(isset($_data_obj->paytoken)){
             $this->_data['paytoken'] = $secured->is_empty($_data_obj->paytoken) ? false : $_data_obj->paytoken;
        }
    }

    //  proceed the marchant payment 
    public function deposite($jr_son = true){

        $mp = new MarchandPayment();
         // return value: true for json and false for array
        return $mp->mpayment( $this->_data, $jr_son);

    }
    //  proceed the cashout balance

    public function cashout($jr_son = true){
      
        $cs = new CashoutBlance();
         // return value: true for json and false for array
        return $cs->cashout( $this->_data, $jr_son);
    }

    //  csheck the payment status
    public function check_status($mp = false, $n_json){

        $cke = new TransactionStatus();
        // check the transacton data : paytoken of the transacton, type of transacton,
        // marchand or cashout, set it true if marchand or false if cashout,
        // return value: true for json and false for array
        $status = $cke->trStatus($this->_data, $mp, $n_json);
    }
    
}