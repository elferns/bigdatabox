<div class="container-fluid" ng-controller="modelCtrl">
    @if(Session::has('successMessage'))
        <div class="alert alert-success" ng-hide="hideDeleteMsg">
            <strong>{{ Session::get('successMessage') }}</strong>
        </div>
    @endif

        <table class="table table-bordered table-striped list-dtable" ng-controller="listing"
               ng-init="init('{!! $moduleName !!}')">
            <thead>
            <tr>
                <td ng-repeat="head in listHead">
                    <a href="#" ng-if="head.sort == true" ng-click="order(head.name)" class="sort-arrows">
                    <% head.label %>
                    <span ng-show="head.sort && !sortReverse && sortType == head.name"
                          class="fa fa-caret-down"></span>
                    <span ng-show="head.sort && sortReverse && sortType == head.name"
                          class="fa fa-caret-up"></span>
                    </a>
                    <span ng-if="head.sort == false" class="sort-arrows"><% head.label %></span>
                </td>
            </tr>
            </thead>
            <tbody>

                <tr ng-repeat="data in listData | orderBy:sortType:sortReverse">
                    <td><% data.name %></td>
                    <td><% data.caption %></td>
                    <td><% data.image_name %></td>
                    <td>
                        <div class="list-dcenter">
                            <i class="fa fa-trash" ng-click="showDeleteConfirm($event, 'page', 6)"></i>
                            <i class="fa fa-pencil" ng-click="showEditPage(6)"></i>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        <div><% links %></div>
    <div>

    </div>
</div>