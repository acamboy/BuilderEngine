<script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>

<ol class="breadcrumb pull-right">
    <li><a href="#">Home</a></li>
    <li><a href="#">Pages</a></li>
    <li class="active">Add New Page</li>
</ol>
<h1 class="page-header">Add New Website Page <small>Module Control Panel</small></h1>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Website Page Details</h4>
        </div>
        <div class="panel-body panel-form">
            <form class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="title">Page Title:</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" id="title" name="title" placeholder="Page Name / Title"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="slug">URL Slug:</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" id="slug" name="slug" placeholder="URL Address Link"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="template">Page Template:</label>
                    <div class="col-md-6 col-sm-6">                             
                        <select class="form-control" id="template" name="template">
                            <?php foreach($theme_pages as $theme_page): ?>
                                <option value="<?=$theme_page?>"><?=$theme_page?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="pagemeta">Page Meta Description:</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" id="pagemeta" name="meta_desc" placeholder="SEO Page Description" data-parsley-required="true" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="pagemetakeywords">Page Meta Keywords:</label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" id="pagemetakeywords" name="meta_keywords" placeholder="SEO Page Keywords" data-parsley-required="true" />
                    </div>
                </div> 
               <!--
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="fullname">Add to Site Map:</label>
                    <div class="col-md-6 col-sm-6">
                        <label class="radio-inline">
                            <input type="radio" name="sitemap1" value="option1" checked />
                            Add to Site Map
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sitemap1" value="option2" />
                            Do Not Add / Hide
                        </label>
                        </div>
                </div>
				-->
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="pagemetakeywords">SEO Restrictions:</label>
                    <div class="col-md-8 col-sm-8">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seo_index" value="" />
                            No Index
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seo_follow" value="" />
                            No Follow
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seo_snippet" value="" />
                            No Snippet
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seo_archive" value="" />
                            No Archive
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seo_img_index" value="" />
                            No Image Index
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seo_odp" value="" />
                            No ODP
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="fullname">Add to Navigation:</label>
                    <div class="col-md-6 col-sm-6">
                        <label class="radio-inline">
                            <input type="radio" name="add_to_nav" value="no" checked />
                            Do Not Add
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="add_to_nav" value="yes" />
                            Add Link
                        </label>
                        <div class="col-md-6 col-sm-6">
                         <select class="form-control" id="select-required" name="link" data-parsley-required="true">
                            <option value="0">No Parent / No Drop-Down</option>
                            <?php foreach(get_links() as $db_link): ?>
                               <option value="<?php echo $db_link->id?>"><?php echo $db_link->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="website">Groups (Accounts) Access Allowed:</label>
                    <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <ul id="access-groups">
                            <li>Guests</li>
                            <li>Members</li>
                        </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 ui-sortable"></label>
                    <div class="col-md-8 col-sm-8 ui-sortable">
                        <input type="submit" class="btn btn-primary" value="Add Page">
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Help Builder</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BuilderEngine Support Forums</td>
                            <td><a href="#modal-dialog" class="btn btn-sm btn-primary" data-toggle="modal">View</a></td>
                        </tr>
                        <tr>
                            <td>BuilderEngine Tutorials/Guides</td>
                            <td><a href="#modal-guides" class="btn btn-sm btn-primary" data-toggle="modal">View</a></td>
                        </tr>
                        <tr>
                            <td>BuilderEngine Support Tickets</td>
                            <td><a href="#modal-tickets" class="btn btn-sm btn-primary" data-toggle="modal">View</a></td>
                        </tr>
                        <tr>
                            <td>BuilderEngine.com Account Login</td>
                            <td><a href="#modal-cloudlogin" class="btn btn-sm btn-success" data-toggle="modal">View</a></td>
                        </tr>
                    </tbody>
                </table>
                <!-- #modal-dialog -->
                <div class="modal fade" id="modal-dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">BuilderEngine Support Forums</h4>
                            </div>
                            <div class="modal-body">
                                You are about to leave your Administration Control Panel, click Continue to view page.
                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                <a href="http://builderengine.com/forums/" class="btn btn-sm btn-success">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-guides">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">BuilderEngine Tutorials/Guides</h4>
                            </div>
                            <div class="modal-body">
                                You are about to leave your Administration Control Panel, click Continue to view page.
                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                <a href="http://builderengine.com/page-support.html" class="btn btn-sm btn-success">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-tickets">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">BuilderEngine Support Tickets</h4>
                            </div>
                            <div class="modal-body">
                                You are about to leave your Administration Control Panel, click Continue to view page.
                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                <a href="http://builderengine.com/page-support.html" class="btn btn-sm btn-success">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-cloudlogin">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">BuilderEngine.com Account Login</h4>
                            </div>
                            <div class="modal-body">
                                You are about to leave your Administration Control Panel, click Continue to view page.
                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                <a href="http://builderengine.com/client/login" class="btn btn-sm btn-success">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
    </div> 
</div>
<?php $groups = new Group();
$groups = $groups->get();?>

<script>
$(document).ready(function (){
    $('#access-groups').tagit({
        fieldName: "groups",
        singleField: true,
        showAutocompleteOnFocus: true,
        availableTags: [ <?php foreach ($groups as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
    });
});
</script>
<script>
function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}
$(document).ready(function (){
    $("#title").keyup(function() {
        $("#slug").val($("#title").val());
        $("#slug").change();
    });     
    
    $("#slug").keyup(function() {
        $("#slug").change();
    });
    $("#slug").change(function() {
        $("#slug").val(convertToSlug($("#slug").val()));
    });
});
</script>