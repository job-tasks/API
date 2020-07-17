<?php

/**
* @author Nikolay Nikolov
*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 *
 * @Route("/api", defaults={"_format": "json"})
 */
class ApiController extends AbstractController
{
    CONST PATTERNS_URL = 'https://raw.githubusercontent.com/easylist/easylist/master/easylist/easylist_general_block.txt';

    /**
     * @Route("/is-url-blocked-by-adblockers", name="is_url_blocked_by_adblockers", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUrlIsBlocked(Request $request)
    {
        try {
            if (!$request->query->has('url')) {
                throw new \Exception('Url parameter is missing!');
            }

            if (!filter_var($request->query->get('url'), FILTER_VALIDATE_URL)) {
                throw new \Exception('Url is not valid!');
            }

            $blocked = false;

            //Get patterns as array
            $patternsArray = explode("\n", file_get_contents(self::PATTERNS_URL));

            foreach ($patternsArray as $pattern) {
                if (!empty($pattern)) {
                    if (preg_match('/' . preg_quote($pattern, '/') . '/', $request->query->get('url'))) {
                        $blocked = true;
                        break;
                    }
                }
            }

            return $this->json(['URL_blocked' => $blocked,], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->json(['Error' => $exception->getMessage()], $exception->getCode() ? $exception->getCode() : Response::HTTP_BAD_REQUEST);
        }
    }
}
