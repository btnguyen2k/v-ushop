<?php
/**
 * Interface for a properties holder.
 *
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Helpers
 * @subpackage PropertiesHelper
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
namespace Ding\Helpers\Properties;

/**
 * Interface for a properties holder.
 *
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Helpers
 * @subpackage PropertiesHelper
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
interface IPropertiesHolder
{
    /**
     * Load properties to the holder.
     *
     * @param string[] $properties New properties.
     *
     * @return void
     */
    public function loadProperties(array $properties);

    /**
     * Set the locations of the properties files.
     *
     * @param mixed[] $locations Can be strings, or IResources.
     *
     * @return void
     */
    public function setLocations($locations);
}