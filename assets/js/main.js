// TODO: SEE LINE 78, MAKE ERROR CONSOLE FORMAT LIKE IN LINE 170
document.addEventListener("DOMContentLoaded", function () {
  /***** UPDATE BUTTONS *****/
  const updateBtns = document.querySelectorAll(".update-btn");
  addEventToNewButton(updateBtns);
  /***** SEARCH BAR TYPING LISTENER *****/
  document.getElementById("searchBar").addEventListener("keyup", async function () {
    const query = this.value;
    const token = document.getElementById("token").value;
    const fetchParam = {
      url: `./backend/search.php`,
      method: "POST",
      headers: { "Content-Type": "applicaiton/json", "CSRF-Token": token },
      body: { q: query, token: token },
    };

    try {
      loadTableData(await fetchingData(fetchParam));
    } catch (error) {
      console.lerror(`Error: ${error}`);
    }
  });

  /***** ADDING ITEM *****/
  document.getElementById("addItemForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = {
      item_name: DOMPurify.sanitize(document.getElementById("itemName").value.trim()),
      quantity: DOMPurify.sanitize(document.getElementById("quantity").value.trim()),
      location: DOMPurify.sanitize(document.getElementById("location").value.trim()),
      description: DOMPurify.sanitize(document.getElementById("description").value.trim()),
      status: DOMPurify.sanitize(document.getElementById("status").value.trim()),
    };

    const missingKey = hasMissingValues(formData);
    if (missingKey) {
      console.error(`Error: Value for key '${missingKey}' is missing or empty!`);
      return;
    } else {
      console.log("All keys have valid values.");
    }

    const fetchParam = {
      url: `./backend/add-item.php`,
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: formData,
    };

    try {
      const data = await fetchingData(fetchParam);

      const addItemModal = document.getElementById("addItemModal");
      const modalInstance = bootstrap.Modal.getInstance(addItemModal) || new bootstrap.Modal(addItemModal);
      modalInstance.hide();

      if (data.status === "success") {
        popupSystemMessage(`System Message: ${data.message}`);

        try {
          const fetchParam = { url: `./backend/get-item.php` };
          const data = await fetchingData(fetchParam);
          loadTableData(data);
        } catch (error) {
          console.error(`Error ${error}`);
        }
      } else {
        console.error(`System Message: ${data.message}`);
        popupSystemMessage(`System Message: ${data.message}`);
      }
    } catch (error) {
      console.error(`Error: ${error.message}`);
    }
  });

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
              <a href="#" class="update-btn btn btn-primary" data-id="${item.id}" data-bs-toggle="modal" data-bs-target=".update-item-modal">Update</a>
              <a href="delete.php?delete_id=${item.id}" class="btn btn-danger">Delete</a>
            </td>
          </tr>
      `;
        });
        const updateBtns = document.querySelectorAll(".update-btn");
        addEventToNewButton(updateBtns);
      }
    } catch (error) {
      console.error(`Error ${error.message}`);
    }
  }

  async function addEventToNewButton(updateBtns) {
    updateBtns.forEach((button) => {
      button.addEventListener("click", async function () {
        const updateId = this.getAttribute("data-id");
        const itemName = document.getElementById("updateItemName");
        const quantity = document.getElementById("updateQuantity");
        const location = document.getElementById("updateLocation");
        const description = document.getElementById("updateDescription");
        const itemStatus = document.getElementById("updateStatus");
        const fetchParam = {
          url: `./backend/select_item.php`,
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: { update_id: updateId },
        };
        try {
          const data = await fetchingData(fetchParam);

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

            console.log(`Status: ${data.status}\nMessage: ${data.message}`);
          } else {
            console.error(`Status: ${data.status}\nMessage: ${data.message}`);
          }
        } catch (error) {
          console.error(`Error fetching data: ${error}`);
          return false;
        }
      });
    });
  }

  function hasMissingValues(dictionary) {
    for (const key in dictionary) {
      if (!dictionary[key]) {
        return key;
      }
    }
    return null;
  }

  /***** FETCHING DATA FUNCTION *****/
  async function fetchingData(fetchParam) {
    const response = await fetch(fetchParam.url, {
      method: fetchParam.method,
      headers: fetchParam.headers,
      body: JSON.stringify(fetchParam.body),
    });
    return await response.json();
  }

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
