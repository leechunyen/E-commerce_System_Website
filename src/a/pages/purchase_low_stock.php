<?php require '../../php_framework/function.php';
checkAdminLogin(true,'purchase-low-stock');?>
<div class="float-left btn-group" role="group">
    <button onclick="goTo('manage-purchase');" type="button" class="btn btn-secondary">Go Back</button>
</div>
<div class="float-right btn-group" role="group">
    <button onclick="reset();" type="button" class="btn btn-secondary">Reset</button>
</div>
<div id="divse" class="float-right input-group mb-3">
    <input id="ipse" type="text" class="form-control" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
        <button onclick="search();" class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
    </div>
</div>
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>Photo</th>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Reorder Point</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tb_adm">
        <tr>
            <td></td><td></td><td></td><td>
                <center><br/><br/>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                <br/><br/></center>
            </td><td></td><td></td>
        </tr>
    </tbody>
</table>
<div>
    <button onclick="previous();" type="button" class="btnp d-inline btn btn-primary btn-sm">Previous</button>
    <button onclick="next();" type="button" class="btnp d-inline btn btn-primary btn-sm">Next</button>
    <div class="d-inline">
        <label  class="d-inline">Total of Result:&nbsp;<label id="oprt">0</label></label>
        &nbsp;&nbsp;&nbsp;
        <div  class="d-inline">
            <label>Number of rows:&nbsp;
                <select onchange="changeNumOfRow();" id="sel_nor">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                    <option value="200">200</option>
                </select>
            </label>
        </div>
    </div>
</div>
<div id="purchas_order_modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="pid" class="hide form-control" type="text"/>
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img id="popdimg" class="card-img" alt="photo">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div>Name:&nbsp;<label id="popdname"></label></div>
                                <div>Modal ID:&nbsp;<label id="popdmid"></label></div>
                                <div>Price:&nbsp;<?php echo$xmldata->Currency;?>&nbsp;<label id="popdprice"></label></div>
                                <div>Stock:&nbsp;<label id="popdstock"></label></div>
                                <div>Reorder Point:&nbsp;<label id="popdreop"></label></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="po_quantity" class="col-sm-3 col-form-label">Quantity</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="po_quantity" placeholder="Quantity">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="po_er_quantity" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="po_price" class="col-sm-3 col-form-label">Price&nbsp;(<?php echo$xmldata->Currency;?>)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="po_price" placeholder="Price">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="po_er_price" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="po_supplier" class="col-sm-3 col-form-label">Supplier</label>
                    <div class="col-sm-9">
                        <select id="po_supplier" style="width: 100%;">
                            <option value="0">--</option>
                            <?php
                            $sql="select * from `manage_supplier`;";
                            $result=mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)>0) {
                              while($row = mysqli_fetch_assoc($result)) {
                                    ?><option value="<?php echo$row['ID'];?>"><?php echo$row['Name'];?></option><?php
                              }
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="op_er_supplier" class="invalid-feedback">
                            Please Select.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="spad" class="hide btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button id="btad" onclick="purchase();" type="button" class="btn btn-primary">Purchase</button>
            </div>
        </div>
    </div>
</div>
<script src="../js/purchase_low_stock.js" type="text/javascript"></script>