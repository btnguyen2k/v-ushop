<?php
/**
 * Interface for a bean factory.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Bean
 * @subpackage Factory
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
namespace Ding\Bean\Factory;

use Ding\Bean\BeanDefinition;

/**
 * Interface for a bean factory.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Bean
 * @subpackage Factory
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
interface IBeanFactory
{
    /**
     * Returns a bean definition.
     *
     * @param string $name Bean name.
     *
     * @return BeanDefinition
     * @throws BeanFactoryException
     */
    public function getBeanDefinition($name);

    /**
     * Sets a bean definition (adds or overwrites).
     *
     * @param string         $name       Bean name.
     * @param BeanDefinition $definition New bean definition.
     *
     * @return void
     */
    public function setBeanDefinition($name, BeanDefinition $definition);

    /**
     * Returns a bean.
     *
     * @param string $name Bean name.
     *
     * @throws BeanFactoryException
     * @return object
     */
    public function getBean($name);

    /**
     * Sets a bean (adds or overwrites).
     *
     * @param string $name Bean name.
     * @param object $bean New object.
     *
     * @return void
     */
    public function setBean($name, $bean);
}
