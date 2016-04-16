<?php

namespace Phphilosophy\Security;

/**
 * Phphilosophy Input Validation
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Validation {
    
    /**
     * @var array
     */
    private $rules = [];
    
    /**
     * @var array
     */
    private $input = [];
    
    /**
     * @var array
     */
    private $messages = [];
    
    /**
     * @param   array   $input
     * @param   array   $rules
     * @param   array   $messages
     */
    public function __construct(
        array $input,
        array $rules,
        array $messages = []
    ) {
        $this->input = $input;
        $this->rules = $rules;
        $this->messages = $messages;
    }
}