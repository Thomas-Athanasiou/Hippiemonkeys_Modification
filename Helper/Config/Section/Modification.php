<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @link https://hippiemonkeys.com
     * @copyright Copyright (c) 2023 Hippiemonkeys Web Intelligence EE All rights Reserved
     * @package Hippiemonkeys_Modification
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\Modification\Helper\Config\Section;

    use Magento\Framework\App\Helper\Context,
        Magento\Store\Model\ScopeInterface,
        Hippiemonkeys\Core\Helper\Config\Section\Group;

    /**
     * Modification configuration section is @deprecated, use \Hippiemonkeys\Core\Helper\Config\Section\Group\Sub instead
     */
    class Modification
    extends Group
    {
        protected const CONFIG_PATH_BASE_GROUP = 'general';

        /**
         * Constructor
         *
         * @access public
         *
         * @param \Magento\Framework\App\Helper\Context $context
         * @param string $section
         * @param string $group
         */
        public function __construct(
            Context $context,
            string $section,
            string $group,
            string $modificationFlagField
        )
        {
            parent::__construct($context, $section, $group);
            $this->_modificationFlagField = $modificationFlagField;
        }

        /**
         * @inheritdoc
         */
        public function getIsActive(): bool
        {
            return $this->getIsModuleActive() && $this->getFlag(
                $this->getModificationFlagField()
            );
        }

        /**
         * @inheritdoc
         */
        public function getIsModuleActive(): bool
        {
            return parent::getIsModuleActive() && $this->getIsBaseGroupActive();
        }

        /**
         * Gets if the Base Group is Active
         *
         * @access protected
         *
         * @return bool
         */
        protected function getIsBaseGroupActive(): bool
        {
            return (bool) $this->getScopeConfig()->isSetFlag(
                $this->getBaseGroupPath(static::CONFIG_FIELD_ACTIVE),
                ScopeInterface::SCOPE_STORE
            );
        }

        /**
         * Gets Base Group Config Path
         *
         * @access protected
         *
         * @param string $field
         *
         * @return string
         */
        protected function getBaseGroupPath(string $field) : string
        {
            return \sprintf(
                static::CONFIG_PATH_FORMAT,
                $this->getSection(),
                static::CONFIG_PATH_BASE_GROUP,
                $field
            );
        }

        /**
         * Modification Group property
         *
         * @access private
         *
         * @var string $_modificationFlagField
         */
        private $_modificationFlagField;

        /**
         * Gets Modification Group
         *
         * @access protected
         *
         * @return string
         */
        protected function getModificationFlagField() : string
        {
            return $this->_modificationFlagField;
        }
    }
?>