import { ThemeOptions, createTheme } from "@mui/material";
import { grey } from "@mui/material/colors";
import { deepmerge } from "@mui/utils";

const defaultTheme: ThemeOptions = {
  palette: {
    primary: {
      main: "#4285F4",
    },
    secondary: {
      main: grey[400],
    },
    success: {
      main: "#34A853",
    },
    error: {
      main: "#EA4335",
    },
    warning: {
      main: "#FBBC05",
    },
    info: {
      main: "#4285F4",
    },
    mode: "light",
  },
  typography: {
    h1: {
      fontFamily: "var(--font-header-family)",
    },
    h2: {
      fontFamily: "var(--font-header-family)",
    },
    h3: {
      fontFamily: "var(--font-header-family)",
    },
    h4: {
      fontFamily: "var(--font-header-family)",
    },
    h5: {
      fontFamily: "var(--font-header-family)",
    },
    h6: {
      fontFamily: "var(--font-header-family)",
    },
    fontFamily: "var(--font-paragraph-family)",
  },
};

export const theme = (config?: ThemeOptions) =>
  createTheme(config ? deepmerge(defaultTheme, config) : defaultTheme);
