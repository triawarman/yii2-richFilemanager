<?php
namespace triawarman\richFilemanager;
        
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/**
 * Description of Filemanager
 *
 * @author Triawarman <i.triawarman@gmail.com>
 */
Class RichFilemanagerView extends Widget
{
    /**
     *
     * @var string that holds AssetsBundle.
     */
    private $bundle;
        
    /**
     *
     * @var string of absolute url to serve data transaction 
     */
    public $apiConnectorUrl;
    
    public $popUp = false;
    
    /**
     *
     * @var array. Each array element represents the richFilemanager configuration,
     * altough only can manipulate culture(language) and theme (for now).
     */
    public $clientConfig = [];
    
    public $callBacks = []; //TODO: will enable this in the future
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();        
        $this->bundle = RichFilemanagerViewAsset::register($this->getView());
    }
    
    /**
     * Renders the widget.
     */
    public function run()
    {                 
        $pluginParams = [];

        if(isset($this->apiConnectorUrl)){
            $pluginParams['config']['api']['connectorUrl'] =  $this->apiConnectorUrl;
        }else{
            //INFO: set default api connectorUrl
            $pluginParams['config']['api']['connectorUrl'] =  Url::to([Yii::$app->controller->id.'/'.'file-manager'], true);
        }
        
        if($this->popUp)
            $pluginParams = ArrayHelper::merge(['popUp' => $this->popUp], $pluginParams);
        
        if(!empty($this->clientConfig)){
            $config =['config' => $this->clientConfig];
            $pluginParams = ArrayHelper::merge($pluginParams, $config); 
        }       
            
        $script = '$(".fm-container").richFilemanager('. json_encode($pluginParams) .');' ;
        
        $this->getView()->registerJs('
            $(function() {
                $(".fm-container").richFilemanager('. json_encode($pluginParams) .');
            });
        ', \yii\web\View::POS_END);
        
        
        return $this->render('interface');
    }
    
    public function getPublishedPath()
    {
        return $this->bundle->baseUrl;
    }
}