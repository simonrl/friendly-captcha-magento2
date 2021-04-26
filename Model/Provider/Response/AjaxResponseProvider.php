<?php

namespace IMI\FriendlyCaptcha\Model\Provider\Response;

use Magento\Framework\App\RequestInterface;
use IMI\FriendlyCaptcha\Model\Provider\ResponseProviderInterface;
use Magento\Framework\Serialize\Serializer\Json;

class AjaxResponseProvider implements ResponseProviderInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Json
     */
    private $decoder;

    /**
     * AjaxResponseProvider constructor.
     *
     * @param RequestInterface $request
     * @param DecoderInterface $decoder
     */
    public function __construct(
        RequestInterface $request,
        Json $decoder
    ) {
        $this->request = $request;
        $this->decoder = $decoder;
    }

    /**
     * Handle friendlyCaptcha failure
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute()
    {
        if ($content = $this->request->getContent()) {
            try {
                $jsonParams = $this->decoder->unserialize($content);
                if (isset($jsonParams['g-friendly-captcha-response'])) {
                    return $jsonParams['g-friendly-captcha-response'];
                }
            } catch (\Exception $e) {
                return '';
            }
        }

        return '';
    }
}
