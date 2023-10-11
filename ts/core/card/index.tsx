import { Box, Paper, styled } from "@mui/material";

export class Card {
  static Container = styled(Paper)(({ theme }) => ({
    position: "relative",
    width: "100%",
    aspectRatio: "3 / 4",
    backgroundColor: theme.palette.grey[300],
  }));
  static Content = styled(Box)({
    position: "absolute",
    bottom: 0,
    width: "100%",
    paddingInline: "1rem",
    paddingBottom: "1rem",
    background: "linear-gradient(transparent, #FFF)",
    "a": {
      color: "inherit",
      textDecoration: "none",
      lineHeight: 1.2,
      fontWeight: 600,
      display: "block",
      "&:before": {
        content: "''",
        display: "block",
        paddingTop: "50%",
      },
      "&:hover": {
        textDecoration: "underline",
      }
    }
  });
  static Media = styled("img")({
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    height: "100%",
    objectFit: "cover",
  })
}
