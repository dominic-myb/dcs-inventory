<div class="page-title d-flex flex-row">
    <div class="row justify-content-center">

        <h1>DCS <?= $PAGE_TITLE ?></h1>

        <div class="col-auto">
            <label for="filter-bar" class="form-label">Filter by:</label>
        </div>

        <div class="col-auto">
            <select id="filter-bar" class="form-select">
                <option value="item_name">Item Name</option>
                <option value="quantity">Quantity</option>
                <option value="location">Location</option>
                <option value="status">Status</option>
            </select>
        </div>

        <div class="col-auto">
            <label for="search-bar" class="form-label">
                Search:
            </label>
        </div>

        <div class="col-auto">
            <input type="text" id="search-bar" class="form-control" placeholder="Search...">
        </div>

        <div class="col-auto">
            <div class="row">
                <div class="wrapper d-flex justify-content-start text-center">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-item-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>Add
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>