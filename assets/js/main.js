// TODO: SEE LINE 78, MAKE ERROR CONSOLE FORMAT LIKE IN LINE 170
document.addEventListener("DOMContentLoaded", function () {
  /***** SEARCH BAR TYPING LISTENER *****/
  document.getElementById("searchBar").addEventListener("keyup", async function () {
    // GET THE QUERY VALUE PLUS THE TOKEN HASH
    const query = this.value;
    const token = document.getElementById("token").value;
    const formData = {
      q: query,
      token: token,
    };

    // SUBMIT QUERY
    try {
      const response = await fetch(`./backend/search.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "CSRF-Token": token,
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json(); // GET RESPONSE FROM SERVER
      loadTableData(data);
    } catch (error) {
      console.lerror(`Error: ${error}`);
    }
  });

  /***** ADDING ITEM *****/
  document.getElementById("addItemForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    // SANITIZE FORM DATA
    const itemName = DOMPurify.sanitize(document.getElementById("itemName").value.trim());
    const quantity = DOMPurify.sanitize(document.getElementById("quantity").value.trim());
    const location = DOMPurify.sanitize(document.getElementById("location").value.trim());
    const description = DOMPurify.sanitize(document.getElementById("description").value.trim());
    const status = DOMPurify.sanitize(document.getElementById("status").value.trim());

    if (itemName === "" || quantity === "" || location === "" || description === "" || status === "") {
      console.error("All fields are required and must not be empty!");
      return;
    }

    if (quantity < 0) {
      console.error("Quantity can't be lower than zero.");
      return;
    }

    const formData = {
      item_name: itemName,
      quantity: quantity,
      location: location,
      description: description,
      status: status,
    };

    try {
      const response = await fetch(`./backend/add-item.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });

      // HIDES THE MODAL FORM AFTER SUBMIT
      const addItemModal = document.getElementById("addItemModal");
      const modalInstance = bootstrap.Modal.getInstance(addItemModal) || new bootstrap.Modal(addItemModal);
      modalInstance.hide();

      const data = await response.json();
      if (data.status === "success") {
        popupSystemMessage(`System Message: ${data.message}`);

        try {
          // !!! MAKE A FUNCTION WITH PARAMETERS FOR FETCHING
          const response = await fetch(`./backend/get-item.php`); // !
          const data = await response.json();
          loadTableData(data);
        } catch (error) {
          console.error("Error: ", error);
        }
      } else {
        console.error(`System Message: ${data.message}`);
        popupSystemMessage(`System Message: ${data.message}`);
      }
    } catch (error) {
      console.error(error.message);
    }
  });

  // FIXME: ISSUE AFTER ADDING AN ITEM THEN PRESSING THE BUTTON UPDATE FOR THE LAST ITEM THE MODAL DOESN'T CONTAIN PREVIOUS DATA

  /***** GET/SHOW ITEMS FUNCTION *****/
  function loadTableData(data) {
    try {
      const tbody = document.getElementById("tableBody");
      if (!tbody) throw new Error("Table body not found");
      tbody.innerHTML = "";

      if (data.length === 0) {
        result.innerHTML = `
          <tr scope="row">
            <td colspan="6">0 Item Listed!</td>
          </tr>
          `;
      } else {
        console.log(`Rendering ${data.length} items.`);
        data.forEach((item) => {
          tbody.innerHTML += `
          <tr scope="row">
            <td>${item.item_name}</td>
            <td>${item.quantity}</td>
            <td>${item.location}</td>
            <td>${item.description}</td>
            <td>${item.status}</td>
            <td>
              <a href="#" class="btn btn-primary" data-id="${item.id}" data-bs-toggle="modal" data-bs-target=".update-item-modal">Update</a>
              <a href="delete.php?delete_id=${item.id}" class="btn btn-danger">Delete</a>
            </td>
          </tr>
      `;
        });
      }
      return true;
    } catch (error) {
      console.error(`Error ${error.message}`);
      return false;
    }
  }

  const updateButtons = document.querySelectorAll(".update-btn");

  updateButtons.forEach((button) => {
    button.addEventListener("click", async function () {
      const updateId = this.getAttribute("data-id");
      const itemName = document.getElementById("updateItemName");
      const quantity = document.getElementById("updateQuantity");
      const location = document.getElementById("updateLocation");
      const description = document.getElementById("updateDescription");
      const itemStatus = document.getElementById("updateStatus");

      try {
        const response = await fetch(`./backend/select_item.php`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ update_id: updateId }),
        });

        const data = await response.json();

        if (data.status === "success") {
          itemName.value = data.item_name;
          quantity.value = data.quantity;
          location.value = data.location;
          description.value = data.description;

          Array.from(itemStatus.options).forEach((option) => {
            if (option.value === data.item_status) {
              option.selected = true;
            }
          });

          console.log(data.message);
        } else {
          console.error(`Status: ${data.status}\n Message: ${data.message}`); // !
        }
      } catch (error) {
        console.error(`Error fetching data: ${error}`);
      }
    });
  });

  /***** TIMED MODAL MESSAGE SHOW *****/
  function popupSystemMessage(title, message) {
    try {
      const modalElement = document.getElementById("popupMsg");
      const titleId = document.getElementById("popupTitle");
      const modalBody = document.getElementById("popupMsgContent");

      if (!modalElement || !titleId || !modalBody) throw new Error("Reference to Id not found.");

      titleId.textContent = title;
      modalBody.textContent = message;

      const modalInstance = new bootstrap.Modal(modalElement);
      modalInstance.show();

      setTimeout(() => {
        modalInstance.hide();
      }, 3000);
    } catch (error) {
      console.error(`Error: ${error}`);
    }
  }
});
