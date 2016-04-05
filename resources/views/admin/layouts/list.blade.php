<div class="container-fluid" ng-controller="listing" ng-init="init('{!! $moduleName !!}')">
    @if(Session::has('successMessage'))
        <div class="alert alert-success" ng-hide="hideDeleteMsg">
            <strong>{{ Session::get('successMessage') }}</strong>
        </div>
    @endif
        <form class="form-inline">
            <div class="form-group">
                {!! Form::label('search', 'Search') !!}
                {!! Form::text('search', null, [ 'class' => 'form-control', 'ng-model'=> 'searchFil',
                               'placeholder' => 'Search' ]) !!}
            </div>
        </form>
        <table class="table table-bordered table-striped list-dtable spacer">
            <thead>
            <tr>
                <td ng-repeat="(hkey,head) in listHead">
                    <a href="#" ng-if="head.sort == true" ng-click="order(hkey)" class="sort-arrows">
                    <% head.label %>
                    <span ng-show="head.sort && !sortReverse && sortType == hkey"
                          class="fa fa-caret-down"></span>
                    <span ng-show="head.sort && sortReverse && sortType == hkey"
                          class="fa fa-caret-up"></span>
                    </a>
                    <span ng-if="head.sort == false" class="sort-arrows"><% head.label %></span>
                </td>
            </tr>
            </thead>
            <tbody>

                <tr dir-paginate="data in listData | orderBy:sortType:sortReverse | filter:searchFil | itemsPerPage:2">
                    <td ng-repeat="(dkey,dtype) in dataType" ng-switch on="dtype">
                        <span ng-switch-when="text"><% data[dkey] %></span>
                        <span ng-switch-when="image">
                            <img ng-if="data[dkey] !== ''" ng-src="/<% imagePath %><% data[dkey] %>" width="200" class="img-thumbnail"/>
                        </span>
                    </td>
                    <td>
                        <div class="list-dcenter" ng-controller="modelCtrl">
                            <i class="fa fa-trash" ng-click="showDeleteConfirm($event, '{!! $moduleName !!}', data.id)"></i>
                            <i class="fa fa-pencil" ng-click="showEditPage(data.id)"></i>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        <dir-pagination-controls max-size="5" direction-links="true" boundry-links="true"></dir-pagination-controls>
    <div>

    </div>
</div>