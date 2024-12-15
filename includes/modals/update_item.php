<div id="updateItemModal" class="modal update-item-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="updateItemForm">

        <div class="modal-header">
          <h5 class="modal-title">Update Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="itemId" id="itemId">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Item Name</span>
            </div>
            <input type="text" id="updateItemName" value="" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" autocomplete="off" required />
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Quantity</span>
            </div>
            <input type="number" min="0" id="updateQuantity" value="" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" autocomplete="off" required />
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Location</span>
            </div>
            <input type="text" id="updateLocation" value="" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" autocomplete="off" required />
          </div>

          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
            </div>
            <textarea id="updateDescription" class="form-control" aria-label="With textarea"></textarea>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Status</span>
            </div>
            <select name="status" id="updateStatus" class="btn btn-secondary btn-sm dropdown-toggle" autocomplete="off" required>
              <option class="status-option" value="In Good Condition">In Good Condition</option>
              <option class="status-option" value="In Bad Condition">In Bad Condition</option>
              <option class="status-option" value="Discontinued">Discontinued</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        </div>

      </form>
    </div>
  </div>
</div>