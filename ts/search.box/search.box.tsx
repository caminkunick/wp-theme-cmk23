import { render } from "preact";
import React from "react";
import {
  Button,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TextField,
  ThemeProvider,
  Box,
  Slide,
  SlideProps,
} from "@mui/material";
import { theme } from "../theme";

export class SearchBox {
  selector: string = "";
  onClose: () => void = () => {};

  constructor(selector: string, onClose: () => void = () => {}) {
    this.selector = selector;
    this.onClose = onClose;
    this.close();
  }

  open() {
    const root = document.querySelector(this.selector);
    if (root) {
      render(
        <ThemeProvider theme={theme()}>
          <SearchBox.Component open={true} onClose={this.onClose} />
        </ThemeProvider>,
        root
      );
    }
  }

  close() {
    const root = document.querySelector(this.selector);
    if (root) {
      render(
        <ThemeProvider theme={theme()}>
          <SearchBox.Component open={false} onClose={this.onClose} />
        </ThemeProvider>,
        root
      );
    }
  }

  static Component(props: { open: boolean; onClose: () => void }) {
    return (
      <form>
        <Dialog
          fullWidth
          maxWidth="xs"
          open={props.open}
          onClose={props.onClose}
          TransitionComponent={Slide}
          TransitionProps={{ direction: "down" } as SlideProps}
        >
          <DialogTitle>ค้นหา</DialogTitle>
          <DialogContent>
            <Box sx={{ pt: 1 }}>
              <TextField label="Search" name="s" fullWidth />
            </Box>
          </DialogContent>
          <DialogActions>
            <Button>Search</Button>
            <Button color="secondary">Cancel</Button>
          </DialogActions>
        </Dialog>
      </form>
    );
  }
}
