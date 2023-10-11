import React from "react";
import {
  Container,
  Grid,
  Link,
  ThemeProvider,
  Typography,
  styled,
} from "@mui/material";
import { render } from "preact";
import { useEffect, useState } from "preact/compat";
import { theme } from "../theme";
import { Card } from "../core/card";
import moment from "moment";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCalendar, faUser } from "@fortawesome/pro-regular-svg-icons";

class Post {
  ID: number = 0;
  post_author: string = "";
  post_date: string = "";
  post_date_gmt: string = "";
  post_content: string = "";
  post_title: string = "";
  post_excerpt: string = "";
  post_status: string = "";
  comment_status: string = "";
  ping_status: string = "";
  post_password: string = "";
  post_name: string = "";
  to_ping: string = "";
  pinged: string = "";
  post_modified: string = "";
  post_modified_gmt: string = "";
  post_content_filtered: string = "";
  post_parent: number = 0;
  guid: string = "";
  menu_order: number = 0;
  post_type: string = "";
  post_mime_type: string = "";
  comment_count: string = "";
  filter: string = "";
  thumbnail: string = "";
  permalink: string = "";

  constructor(post?: Partial<Post>) {
    if (post) {
      Object.assign(this, post);
    }
  }

  Title(): string {
    const regex = /(<([^>]+)>)/gi;
    const title = this.post_title.replace(regex, "");
    return title;
  }
}

export class SearchResult {
  selector: string = "";
  posts: Partial<Post>[] = [];

  constructor(selector: string, posts: Partial<Post>[] = []) {
    this.selector = selector;
    this.posts = posts;
    this.open();
  }

  open() {
    const root = document.querySelector(this.selector);
    if (root) {
      render(
        <ThemeProvider theme={theme()}>
          <SearchResult.Component open={true} posts={this.posts} />
        </ThemeProvider>,
        root
      );
    }
  }

  static Component(props: { open: boolean; posts: any[] }) {
    const [state, setState] = useState<Post[]>([]);

    useEffect(() => {
      if (props.posts.length > 0) {
        setState(props.posts.map((p) => new Post(p)));
      }
    }, [props.posts]);

    return (
      <Container maxWidth="md" sx={{ pt: 6 }}>
        <div></div>
        <Grid container spacing={2}>
          {state.map((post, index) => (
            <Grid item xs={12} sm={6} md={4} key={index}>
              <Card.Container>
                {post.thumbnail && (
                  <Card.Media src={post.thumbnail} alt={post.Title()} />
                )}
                <Card.Content>
                  <Link variant="h6" href={post.permalink} target="_blank">
                    {post.Title()}
                  </Link>
                  <FontAwesomeIcon icon={faCalendar} />
                  {moment(post.post_date).format("YYYY-MM-DD")}
                  <FontAwesomeIcon icon={faUser} />
                </Card.Content>
              </Card.Container>
            </Grid>
          ))}
        </Grid>
      </Container>
    );
  }

  static Title = styled(Typography)({
    display: "-webkit-box",
    WebkitLineClamp: 3,
    WebkitBoxOrient: "vertical",
    overflow: "hidden",
  });
}
