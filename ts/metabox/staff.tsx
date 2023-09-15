import React, { useEffect } from "preact/compat";
import { render } from "preact";
import { useReducer } from "preact/hooks";
import { ChangeEvent } from "preact/compat";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/pro-regular-svg-icons";

//SECTION - MetaStaff
export class MetaStaff {
  selector: string = "#staff";

  constructor(selector?: string) {
    if (selector) {
      this.selector = selector;
    }
  }

  render(data?: any) {
    const root = document.querySelector(this.selector);
    if (root) {
      render(<MetaStaffComponent data={data} />, root);
    }
  }
}
//!SECTION

//SECTION - MetaStaffDocument
type MetaStaffDocumentAction =
  | { type: "name-add" }
  | { type: "init"; payload: Partial<MetaStaffDocument> }
  | { type: "name-edit"; value: string; index: number }
  | { type: "position"; value: string };
class MetaStaffDocument {
  name: string[] = [""];
  position: string = "";

  constructor(data?: any) {
    Object.entries(this).forEach(([key, value]) => {
      if (value instanceof Function === false && data?.[key]) {
        this[key] = data[key];
      }
    });
  }

  static reducer(
    state: MetaStaffDocument,
    action: MetaStaffDocumentAction
  ): MetaStaffDocument {
    switch (action.type) {
      case "name-add":
        return new MetaStaffDocument({
          ...state,
          name: [...state.name, ""],
        });
      case "name-edit":
        return new MetaStaffDocument({
          ...state,
          name: state.name.map((name, index) => {
            if (index === action.index) {
              return action.value;
            }
            return name;
          }),
        });
      case "init":
        return new MetaStaffDocument(action.payload);
      case "position":
        return new MetaStaffDocument({
          ...state,
          position: action.value,
        });
      default:
        return state;
    }
  }
}
//!SECTION

//SECTION - MetaStaffComponent
const MetaStaffComponent = ({ data }: { data?: any }) => {
  const [staff, dispatch] = useReducer(
    MetaStaffDocument.reducer,
    new MetaStaffDocument()
  );

  useEffect(() => {
    if (data) {
      dispatch({ type: "init", payload: data });
    }
  }, [data]);

  return (
    <>
      <input
        type="hidden"
        name="staff_data"
        value={JSON.stringify(staff)}
        readOnly
      />
      <table>
        <tbody>
          <tr>
            <td width={72}>ชื่อ (อื่นๆ)</td>
            <td>
              <div
                className="stack"
                style={{
                  display: "flex",
                  flexDirection: "column",
                  alignItems: "flex-start",
                  gap: 4,
                }}
              >
                {staff.name.map((name, index) => (
                  <div
                    key={index}
                    style={{ display: "flex", alignItems: "center" }}
                  >
                    <button
                      className="cmk-del-btn"
                      type="button"
                      style={{ marginRight: "0.25rem" }}
                    >
                      <i className="fas fa-times-circle"></i>
                    </button>
                    <input
                      type="text"
                      value={name}
                      onChange={({ target: { value } }: any) =>
                        dispatch({ type: "name-edit", index, value })
                      }
                    />
                  </div>
                ))}
                <button
                  class="button button-secondary button-large"
                  type="button"
                  onClick={() => dispatch({ type: "name-add" })}
                >
                  Add
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>ตำแหน่ง</td>
            <td>
              <input
                type="text"
                value={staff.position}
                onChange={({ target: { value } }: any) =>
                  dispatch({ type: "position", value })
                }
              />
            </td>
          </tr>
        </tbody>
      </table>
    </>
  );
};
//!SECTION
