/**
 * Define utils to save/load canvas status with local storage
 */

window.saveInBrowser = {
  openDatabase: async () => {
    return new Promise((resolve, reject) => {
      const request = indexedDB.open("LPBDB", 1);
      request.onupgradeneeded = function (event) {
        const db = event.target.result;
        if (!db.objectStoreNames.contains("canvasEditor")) {
          db.createObjectStore("canvasEditor", { keyPath: "name" });
        }
      };
      request.onsuccess = function (event) {
        resolve(event.target.result);
      };
      request.onerror = function () {
        reject("Error opening the database");
      };
    });
  },

  save: async (name, value) => {
    // If the item is an object, stringify it
    if (value instanceof Object) {
      value = JSON.stringify(value);
    }

    try {
      const db = await saveInBrowser.openDatabase();
      const transaction = db.transaction(["canvasEditor"], "readwrite");
      const objectStore = transaction.objectStore("canvasEditor");
      objectStore.put({ name, value });
      transaction.oncomplete = function () {
        db.close();
        console.log("Canvas state saved in IndexedDB. Value: ", value);
      };
    } catch (error) {
      console.error(error);
    }
  },

  load: async (name) => {
    try {
      const db = await saveInBrowser.openDatabase();

      if (db.objectStoreNames.contains("canvasEditor")) {
        const transaction = db.transaction(["canvasEditor"], "readonly");
        const objectStore = transaction.objectStore("canvasEditor");
        const getRequest = objectStore.get(name);

        return new Promise((resolve, reject) => {
          getRequest.onsuccess = function () {
            const value = getRequest.result;
            if (value) {
              resolve(JSON.parse(value.value));
              console.log("Value loaded: ", value);
            } else {
              resolve(null);
            }
          };

          getRequest.onerror = function () {
            reject("Error loading canvas state");
          };

          transaction.oncomplete = function () {
            db.close();
          };
        });
      } else {
        return null;
      }
    } catch (error) {
      console.error(error);
      return null;
    }
  },

  remove: async (name) => {
    try {
      const db = await saveInBrowser.openDatabase();
      const transaction = db.transaction(["canvasEditor"], "readwrite");
      const objectStore = transaction.objectStore("canvasEditor");
      objectStore.delete(name);
      transaction.oncomplete = function () {
        db.close();
        console.log(`Item ${name} removed from IndexedDB.`);
      };
    } catch (error) {
      console.error(error);
    }
  },

  loadCanvasStateAndDimensions: async (_self) => {
    try {
      let savedWidth = await saveInBrowser.load("canvasWidth");
      let savedHeight = await saveInBrowser.load("canvasHeight");

      if (savedWidth && savedHeight) {
        _self.canvas.setWidth(savedWidth);
        _self.canvas.originalW = savedWidth;
        _self.canvas.setHeight(savedHeight);
        _self.canvas.originalH = savedHeight;

        // Load canvas state after setting the canvas size
        let savedCanvasState = await saveInBrowser.load("canvasEditor");
        if (savedCanvasState) {
          _self.canvas.loadFromJSON(savedCanvasState, () => {
            _self.canvas.renderAll();
          });
        }
      }
    } catch (error) {
      console.error("Error loading canvas state and dimensions:", error);
    }
  },
};

// window.saveInBrowser = {
//   save: (name, value) => {
//     // If the item is an object, stringify it
//     if (value instanceof Object) {
//       value = JSON.stringify(value);
//     }

//     sessionStorage.setItem(name, value);
//   },
//   load: (name) => {
//     let value = sessionStorage.getItem(name);
//     value = JSON.parse(value);

//     return value;
//   },
//   remove: (name) => {
//     sessionStorage.removeItem(name);
//   },
//   loadCanvasStateAndDimensions: (_self) => {
//     let savedCanvasState = saveInBrowser.load("canvasEditor");
//     if (savedCanvasState) {
//       _self.canvas.loadFromJSON(savedCanvasState, () => {
//         let savedWidth = saveInBrowser.load("canvasWidth");
//         let savedHeight = saveInBrowser.load("canvasHeight");
//         if (savedWidth && savedHeight) {
//           _self.canvas.setWidth(savedWidth);
//           _self.canvas.originalW = savedWidth;
//           _self.canvas.setHeight(savedHeight);
//           _self.canvas.originalH = savedHeight;
//           _self.canvas.renderAll();
//         }
//       });
//     }
//   },
// };
