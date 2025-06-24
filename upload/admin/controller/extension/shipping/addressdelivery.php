<?php
class ControllerExtensionShippingAddressDelivery extends Controller {
    public function index(): void {
        $this->load->language('extension/shipping/addressdelivery');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->user->hasPermission('modify', 'extension/shipping/addressdelivery')) {
            $this->model_setting_setting->editSetting('shipping_addressdelivery', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'type=shipping'));
        }

        $data['action'] = $this->url->link('extension/shipping/addressdelivery');
        $data['cancel'] = $this->url->link('marketplace/extension', 'type=shipping');

        $data['shipping_addressdelivery_cost'] = $this->config->get('shipping_addressdelivery_cost');
        $data['shipping_addressdelivery_geo_zone_id'] = $this->config->get('shipping_addressdelivery_geo_zone_id');
        $data['shipping_addressdelivery_status'] = $this->config->get('shipping_addressdelivery_status');
        $data['shipping_addressdelivery_sort_order'] = $this->config->get('shipping_addressdelivery_sort_order');

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/addressdelivery', $data));
    }
}

