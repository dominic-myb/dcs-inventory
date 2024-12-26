<div id="deleteItemModal" class="modal delete-item-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteItemForm">

        <div class="modal-header">
          <h5 class="modal-title">Delete Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="itemId" id="itemId">
          <p>Are you sure that you want to delete, <span id="itemNameDisplay"></span>?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="saveBtn">Delete</button>
        </div>

      </form>
    </div>
  </div>
</div>