<?php 
class GlobalDef extends CApplicationComponent
{
  public $MSG_TRANSACTION_FAILED = 'Your transaction has failed. Please try again'; 
  public $SKOOB_ADMIN_EMAIL = 'admin@skoob.com';
  public $MSG_NO_VOUCHERS = "Sorry, we have run out of vouchers. Unable to proceed. Please contact <a href='mailto:%s'>%s</a>"; 
  public $MSG_SESSION_TIMEOUT = "Your session has timed out. Please create a new egift";
  public $CREDIT_CARD_MIN_LENGTH = 16;
  public $CURRENCY = 'SGD';
  public $CURRENCY_SYM = 'S$';
  public $MIGS_PARTNER_ID = '75';
  public $MIGS_SERVER = 'http://203.125.232.201:7777/paymentservermigs/';
  public $MIGS_PROJECT_ID = '2';
  public $GIFT_CARD_MAX_HEIGHT = 300;
  public $GIFT_CARD_MAX_WIDTH = 563;
  public $GIFT_CARD_DIR = '/images/egift_cards/';
  public $SKOOB_INTRO = 'skoob, Singapore\'s Favourite eBookstore has more than 87,000 international
						titles that includes bestsellers from the New York Times and Sunday Times.
						Start enjoying your favourite eBooks on up to 5 devices today!';
	public $SKOOB_EMAIL_SUB_TEXT = 'For enquiries or feedback, please contact us at <a href="mailto:feedback@skoob.com.sg">feedback@skoob.com.sg</a>. Terms &amp; Conditions apply.';
	public $SKOOB_URL = 'www.skoob.com.sg';
	public $SKOOB_EVOUCHER_TAC = 'www.skoob.com.sg/eGiftvouchers';
	
	public $EMAIL_ORDER_RECEIPT_SUBJECT = 'Your skoob Order Receipt No. %s';
	public $EMAIL_DELIVERED_GIFT_SUBJECT = 'Your skoob Order %s has been delivered';
	public $EMAIL_GIFT_CLAIM_SUBJECT = 'You have a gift from %s';
	public $MIGS_DEFAULT_TXN_MSG = 'cancelled';
	
	public $LIVE_SITE_NEW_RELEASE_URL = 'https://www.skoob.com.sg/shop/category/New%20Releases?isPromoCategoryPage=true';
	public $LIVE_SITE_BEST_SELLERS_URL = 'https://www.skoob.com.sg/shop/category/bestsellers?isPromoCategoryPage=true';
	
	public $SESSION_VAR_CHECKOUT_ID = 'checkout_id';
	public $SESSION_VAR_EGIFT_ID = 'egift_id';
	
	public $EMAIL_SENT_TYPE_DELIVERED = 'DELIVERED EGIFT';
	public $EMAIL_SENT_TYPE_CLAIM = 'CLAIM EGIFT';
	public $EMAIL_SENT_TYPE_RECEIPT = 'ORDER RECEIPT';
	public $EMAIL_SENT_TYPE_EGIFT_REQUESTED = 'EGIFT REQUESTED';
	public $EMAIL_SENT_TYPE_EGIFT_VOUCHER_CLAIMED = 'VOUCHER CLAIMED';
	
	public $CLAIM_GIFT_SUCCESS = 0;
	public $CLAIM_GIFT_ERROR_USER_NAME_WRONG = 501;
	public $CLAIM_GIFT_ERROR_PASSWORD_WRONG = 502;
	public $CLAIM_GIFT_ERROR_VOUCHER_NOT_FOUND = 901;
}