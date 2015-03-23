<?php

namespace Zendesk\API;

/**
 * The Groups class exposes ticket group information
 */
class HCSections extends ClientAbstract {

    const OBJ_NAME = 'section';
    const OBJ_NAME_PLURAL = 'sections';

    /*
     * List all groups
     */
    public function findAll(array $params = array()) {
        if($this->client->users()->getLastId() != null) {
            $params['user_id'] = $this->client->users()->getLastId();
            $this->client->users()->setLastId(null);
        }
        $endPoint = Http::prepare('help_center/sections.json', $this->client->getSideload($params), $params);
        $response = Http::send($this->client, $endPoint);
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /*
     * Show a specific group
     */
    public function find(array $params = array()) {
        if($this->lastId != null) {
            $params['id'] = $this->lastId;
            $this->lastId = null;
        }
        if(!$this->hasKeys($params, array('id'))) {
            throw new MissingParametersException(__METHOD__, array('id'));
        }
        $endPoint = Http::prepare('help_center/sections/'.$params['id'].'.json?include=access_policies', $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint);
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /*
     * Create a new group
     */
    public function create(array $params) {
        $endPoint = Http::prepare('help_center/categories/sections.json');
        $response = Http::send($this->client, $endPoint, array(self::OBJ_NAME => $params), 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /*
     * Update a group
     */
    public function update(array $params) {
        if($this->lastId != null) {
            $params['id'] = $this->lastId;
            $this->lastId = null;
        }
        if(!$this->hasKeys($params, array('id'))) {
            throw new MissingParametersException(__METHOD__, array('id'));
        }
        $id = $params['id'];
        unset($params['id']);
        $endPoint = Http::prepare('help_center/sections/'.$id.'.json');
        $response = Http::send($this->client, $endPoint, array(self::OBJ_NAME => $params), 'PUT');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /*
     * Delete a group
     */
    public function delete(array $params = array()) {
        if($this->lastId != null) {
            $params['id'] = $this->lastId;
            $this->lastId = null;
        }
        if(!$this->hasKeys($params, array('id'))) {
            throw new MissingParametersException(__METHOD__, array('id'));
        }
        $endPoint = Http::prepare('help_center/sections/'.$params['id'].'.json');
        $response = Http::send($this->client, $endPoint, null, 'DELETE');
        if ($this->client->getDebug()->lastResponseCode != 200) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return true;
    }


}
