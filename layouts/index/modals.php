<!-- ########## START OF ADD ITEM MODAL IN INDEX.HTML ########### -->

<div id="add-item-modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="add-item-form" method="post">

                    <label>Item Name</label>
                    <input type="text" name="item-name" required>
                    <label>Quantity</label>
                    <input type="number" name="quantity" required>
                    <label>Location</label>
                    <input type="text" name="location" required>
                    <label>Description</label>
                    <textarea name="description"></textarea>
                    <label>Status</label>
                    <select name="status" id="status" class="btn btn-primary btn-sm dropdown-toggle" required>
                        <option value="In Good Condition">In Good Condition</option>
                        <option value="In Bad Condition">In Bad Condition</option>
                        <option value="Discontinued">Discontinued</option>
                    </select>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
</div>

<!-- ########### END OF ADD ITEM MODAL IN INDEX.HTML ############ -->