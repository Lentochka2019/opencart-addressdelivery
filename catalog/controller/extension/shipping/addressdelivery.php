<?php
class ModelExtensionShippingAddressDelivery extends Model {
    public function getQuote($address) {
        $this->load->language('extension/shipping/addressdelivery');

        $status = true;

        if ($this->config->get('shipping_addressdelivery_geo_zone_id')) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone
                WHERE geo_zone_id = '" . (int)$this->config->get('shipping_addressdelivery_geo_zone_id') . "'
                AND country_id = '" . (int)$address['country_id'] . "'
                AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

            if (!$query->num_rows) {
                $status = false;
            }
        }

        if ($status) {
            $quote_data['addressdelivery'] = [
                'code'         => 'addressdelivery.addressdelivery',
                'title'        => $this->language->get('text_description'),
                'cost'         => (float)$this->config->get('shipping_addressdelivery_cost'),
                'tax_class_id' => 0,
                'text'         => $this->currency->format((float)$this->config->get('shipping_addressdelivery_cost'), $this->session->data['currency'])
            ];

            return [
                'code'       => 'addressdelivery',
                'title'      => $this->language->get('text_title'),
                'quote'      => $quote_data,
                'sort_order' => $this->config->get('shipping_addressdelivery_sort_order'),
                'error'      => false
            ];
        }

        return [];
    }
}
?>
