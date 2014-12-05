<?php
class promo_readyViewGmp extends viewGmp {
	private $_gmapProdLink = 'http://readyshoppingcart.com/product/google-maps-plugin/';
    public function displayAdminFooter() {
        parent::display('adminFooter');
    }
	public function showWelcomePage() {
		$this->assign('askOptions', array(
			1 => array('label' => 'Google'),
			2 => array('label' => 'Wordpress.org'),
			3 => array('label' => 'Refer a friend'),
			4 => array('label' => 'Find on the web'),
			5 => array('label' => 'Other way...'),
		));
		parent::display('welcomePage');
	}
	public function showAdminSendStatNote() {
		parent::display('adminSendStatNote');
	}
	private function _generateProFields($proFields) {
		$this->assign('promoModPath', 'https://readyshoppingcart.com/gmap_files/');
		$this->assign('proLinkPrepared', $this->getModule()->preparePromoLink($this->_gmapProdLink));
		$this->assign('proFields', $proFields);
		return parent::getContent('_proGenerateFields');
	}
	public function showProAdminPromoButtons() {
		$modPath = $this->getModule()->getModPath();
		$listAvailableDirectionsViews = array(
			//5 => array('label' => 'Slider mini'),
			6 => array('label' => 'Slider mini'),
			4 => array('label' => 'First Table'),
			1 => array('label' => 'Second Table'),
		);
		foreach($listAvailableDirectionsViews as $id => $v) {
			$listAvailableDirectionsViews[ $id ]['prev_img'] = $modPath. 'img/prev_marker_list/'. $id. '.jpg';
		}
		$listAvailableCustomControls = array(
			'simple' => array('label' => langGmp::_('Simple')),
			'pro_search' => array('label' => langGmp::_('PRO Search')),
			'ultra' => array('label' => langGmp::_('Ultra')),
		);
		foreach($listAvailableCustomControls as $c => $data) {
			$listAvailableCustomControls[ $c ]['code'] = $c;
			$listAvailableCustomControls[ $c ]['prev_img'] = $modPath. 'img/prev_cust_map_controls/'. $c. '.jpg';
		}
		$fetchStyles = array(
			'Bentley' => array(),
			'Icy Blue' => array(),
			'Snazzy Maps' => array(),
			'Subtle' => array(),
			'Apple Maps' => array(),
			'Neutral Blue' => array(),
			'Shift Worker' => array(),
			'Subtle Grayscale' => array(),
			'Pale Dawn' => array(),
			'Blue water' => array(),
			'Midnight Commander' => array(),
			'Retro' => array(),
		);
		$stylesList = array();
		foreach($fetchStyles as $label => $sData) {
			$code = str_replace(' ', '-', $label);
			$stylesList[ $code ] = $sData;
			$stylesList[ $code ]['code'] = $code;
			$stylesList[ $code ]['label'] = $label;
			$stylesList[ $code ]['prev_img'] = $modPath. 'img/prev_styles/'. $code. '.jpg';
		}
		$proFields = array(
			'enable_marker_clasterer' => array('type' => 'checkbox', 'label' => __('Enable markers clasterization'), 'desc' => __('If there will be too many markers in area - they will be combined into one point, after click on it - you will see all combined markers')),
			'markers_list_show_only_visible' => array('type' => 'checkbox', 'label' => __('Show only visible markers in list'), 'desc' => __('Markers visible on map for current position will be shown in markers list')),
			'disable_search_table' => array('type' => 'checkbox', 'label' => __('Disable search in markers list'), 'desc' => __('Will disable search element in markers list')),
			'disable_categories_selection' => array('type' => 'checkbox', 'label' => __('Disable categories selection'), 'desc' => __('Will disable categories selection for markers list')),
		);
		$this->assign('listAvailableDirectionsViews', $listAvailableDirectionsViews);
		$this->assign('listAvailableCustomControls', $listAvailableCustomControls);
		$this->assign('stylesList', $stylesList);
		$this->assign('proLink', $this->_gmapProdLink);
		$this->assign('modPath', $modPath);
		$this->assign('proFieldsHtml', $this->_generateProFields($proFields));
		parent::display('proAdminPromoButtons');
	}
	public function showProAdminFormEndPromo() {
		$proFields = array(
			'markers_desc_show_get_direction' => array('type' => 'checkbox', 'label' => __('"Get Directions" link'), 'desc' => __('Show or not "Get Directions" link in infowindow'), 'startCon' => array(
				'label' => __('Additional links'), 'desc' => __('Additional links for map markers infowindows'),
			)),
			'markers_desc_show_view_on_google_maps' => array('type' => 'checkbox', 'label' => __('"View on Google Maps" link'), 'desc' => __('Show or not "View on Google Maps" link in infowindow'), 'endCon' => true),
			
			'enable_full_screen_btn' => array('type' => 'checkbox', 'label' => __('Enable full screen button'), 'desc' => __('Show full screen button your near map'), 'startCon' => array(
				'label' => __('Full screen'), 'desc' => __('Full screen map features'),
			), 'endCon' => true),
			
			'enable_embed_view' => array('type' => 'checkbox', 'label' => __('Enable embed view'), 'desc' => __('If enabled - iframe embed view will be used for your map'), 'startCon' => array(
				'label' => __('Embed view type'), 'desc' => __('Allow to view map in embed view mode'),
			), 'endCon' => true),
			
			'ad_publisher_id' => array('type' => 'text', 'label' => __('Publisher ID'), 'desc' => __('Just leave this field empty - if you don\'t want to show AD on your map'), 'startCon' => array(
				'label' => __('Google Adsense'), 'desc' => __('Enable Google Adsense on your map'),
			)),
			'ad_pos' => array('type' => 'selectbox', 'label' => __('Position'), 'desc' => __('AD block position'), 'htmlParams' => array('options' => frameGmp::_()->getModule('gmap')->getControlsPositions()), 'endCon' => true),
			
			'enable_trafic_layer' => array('type' => 'checkbox', 'label' => __('Enable Traffic Layer'), 'desc' => __('Add Traffic Layer to your map'), 'startCon' => array(
				'label' => __('Traffic, Transit and Bicycling Layer'), 'desc' => __('Allow to add additional traffic, transit and bicycling layers'),
			)),
			'enable_transit_layer' => array('type' => 'checkbox', 'label' => __('Enable Transit Layer'), 'desc' => __('Add Transit Layer to your map')),
			'enable_bicycling_layer' => array('type' => 'checkbox', 'label' => __('Enable Bicycling Layer'), 'desc' => __('Add Bicycling Layer to your map'), 'endCon' => true),
		);
		$this->assign('proFieldsHtml', $this->_generateProFields($proFields));
		$this->assign('proLinkPrepared', $this->getModule()->preparePromoLink($this->_gmapProdLink));
		$this->assign('proLink', $this->_gmapProdLink);
		$this->assign('modPath', $this->getModule()->getModPath());
		parent::display('proAdminFormEndPromo');
	}
	public function getUnderMapAdminFormData() {
		return parent::getContent('underMapAdminFormData');
	}
}
