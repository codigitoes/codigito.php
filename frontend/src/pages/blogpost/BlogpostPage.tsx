import { Tag } from "@mui/icons-material";
import { TabContext, TabList, TabPanel } from "@mui/lab";
import { Box, CircularProgress, Stack, Tab } from "@mui/material";
import React from "react";
import { Link, useNavigate, useParams } from "react-router-dom";
import HoverChip from "../../components/hoverchip/HoverChip";
import useFetch from "../../hooks/useFetch";
import "./blogpost.scss";

interface Blogpost {
  id: string;
  name: string;
  image: string;
  youtube: string;
  tags: string[];
  created: string;
  html: string | null;
  others?: Blogpost[];
}

const endpoint = "http://localhost:8001/api/client/web/blogposts/";
const endpointFilter = "/blogposts/tag/";

const BlogpostPage: React.FC = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const fetchState = useFetch<{
    blogpost: Blogpost;
    tags: string[];
    others?: Blogpost[];
  }>(endpoint + id);

  const [value, setValue] = React.useState("0");
  if (fetchState.state === "loading" || fetchState.state === "idle") {
    return (
      <div>
        <CircularProgress />
      </div>
    );
  }

  const handleChange = (_event: React.SyntheticEvent, newValue: string) => {
    setValue(newValue);
  };

  const blogpost = fetchState.data?.blogpost;
  const others = fetchState.data?.others || [];

  return (
    <div className="blogpost-page">
      <Box sx={{ width: "100%", typography: "body1" }}>
        <TabContext value={value}>
          <TabList onChange={handleChange} aria-label="lab API tabs example">
            <Tab className="tab-title" label="Contenido" value="0" />
            <Tab className="tab-title" label="Relacionados" value="2" />
          </TabList>
          <TabPanel value="0">
            <Stack
              direction="row"
              justifyContent="left"
              alignItems="center"
              spacing={2}
              margin={2}
            >
              {blogpost?.tags.map((tag) => (
                <HoverChip
                  label={tag}
                  key={tag}
                  onClick={() => navigate(endpointFilter + tag)}
                  icon={<Tag />}
                />
              ))}
            </Stack>
            <div
              style={{
                width: "90%",
              }}
            >
              <div className="video-responsive box">
                <iframe
                  src={blogpost?.youtube}
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowFullScreen
                  title="Embedded youtube"
                />
              </div>
            </div>
          </TabPanel>
          <TabPanel value="2">
            <div className="blog-page">
              {others.map((aBlogpost: Blogpost) => {
                if (aBlogpost.id === blogpost?.id) {
                  return null;
                }
                return (
                  <Link
                    to={`/blogposts/${aBlogpost.id}`}
                    key={aBlogpost.id}
                    onClick={() => setValue("0")}
                  >
                    <div className="box blog-item">
                      <img src={aBlogpost.image} alt="" />
                      <span>{aBlogpost.name}</span>
                    </div>
                  </Link>
                );
              })}
            </div>
          </TabPanel>
        </TabContext>
      </Box>
    </div>
  );
};

export default BlogpostPage;
