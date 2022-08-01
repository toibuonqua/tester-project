<?php

namespace App\Http\Controllers\Web;

use App\Common\ValidFixer;
use Exception;
use Illuminate\Http\Request;

trait PaginationTrait
{
    public $DEFAULT_PAGE = 1;
    public $DEFAULT_LIMIT = 10;

    private function getPaginationParam(Request $request, $totalItem)
    {
        try {
            $limit = intval($this->makeValidNumberPerPageLimit($request->session()->get('_numberPerPage')));
        } catch (Exception $e) {
            $limit = $this->DEFAULT_LIMIT;
        }

        $currentPage = $request->input('page') ?? $this->DEFAULT_PAGE;
        $offset = ($currentPage - 1) * $limit;
        $totalPage = floor(($totalItem - 1) / $limit) + 1;

        return [
            'limit' => $limit,
            'offset' => $offset,
            'totalPage' => $totalPage,
            'currentPage' => $currentPage,
        ];
    }

    public $MIN_LIMIT = 10;
    public $MAX_LIMIT = 100;

    public function updateNumberPerPageSession(Request $request, $updateNumber)
    {
        $numberPerPage = intval($updateNumber) ?? $this->DEFAULT_LIMIT;
        $numberPerPageFixed = $this->makeValidNumberPerPageLimit($numberPerPage);
        $request->session()->put('_numberPerPage', $numberPerPageFixed);
    }

    private function makeValidNumberPerPageLimit($numberPerPage)
    {
        $validFixer = new ValidFixer();
        return $validFixer->fixNumberInRange($numberPerPage, $this->MIN_LIMIT, $this->MAX_LIMIT);
    }
}
