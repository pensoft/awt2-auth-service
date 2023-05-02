<?php
namespace App\API\V1\Controllers\Users;

use App\API\V1\Controllers\BaseController;
use App\Models\User;
use App\QueryBuilder\Filters\FiltersExactOrNotExact;
use App\QueryBuilder\Filters\FiltersUserOrEmail;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetUsersController extends BaseController
{
    public function __invoke(Request $request)
    {
        $pageSize = $request->get('pageSize', 10);

        $articles = QueryBuilder::for(User::class)
            ->defaultSort('name')
            ->allowedSorts('name')
            ->allowedFilters(AllowedFilter::custom('search', new FiltersUserOrEmail))->paginate($pageSize);

        $filters = request()->query();


        return $this->response->paginator($articles, new UserTransformer)->setMeta($filters);
    }
}
