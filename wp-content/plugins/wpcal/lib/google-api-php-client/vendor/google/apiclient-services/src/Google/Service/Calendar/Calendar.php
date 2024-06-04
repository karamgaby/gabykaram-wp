<?php

namespace WPCal\GoogleAPI;

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
class Google_Service_Calendar_Calendar extends \WPCal\GoogleAPI\Google_Model
{
    protected $conferencePropertiesType = 'WPCal\\GoogleAPI\\Google_Service_Calendar_ConferenceProperties';
    protected $conferencePropertiesDataType = '';
    public $description;
    public $etag;
    public $id;
    public $kind;
    public $location;
    public $summary;
    public $timeZone;
    /**
     * @param Google_Service_Calendar_ConferenceProperties
     */
    public function setConferenceProperties(\WPCal\GoogleAPI\Google_Service_Calendar_ConferenceProperties $conferenceProperties)
    {
        $this->conferenceProperties = $conferenceProperties;
    }
    /**
     * @return Google_Service_Calendar_ConferenceProperties
     */
    public function getConferenceProperties()
    {
        return $this->conferenceProperties;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    public function getSummary()
    {
        return $this->summary;
    }
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    public function getTimeZone()
    {
        return $this->timeZone;
    }
}
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
\class_alias('WPCal\\GoogleAPI\\Google_Service_Calendar_Calendar', 'Google_Service_Calendar_Calendar', \false);