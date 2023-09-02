import { Container, Grid, Paper, Typography } from "@mui/material";
import React from "react";
import useFetch from "../hooks/useFetch";

interface Blogpost {
    id: string;
    name: string;
    image: string;
    tags: string[];
    created: string;
}

const endpoint: string = 'http://localhost:8001/api/client/web/list';
const HomePage: React.FC = () => {
    // const navigate = useNavigate();

    const fetchState = useFetch<{
        blogposts: Blogpost[]
    }>(endpoint);
    if (fetchState.state === 'loading' || fetchState.state === 'idle') {
        return (<Container sx={{ mt: 9 }} maxWidth="xl">
            <Typography>loading...</Typography>
        </Container>);
    }

    const blogposts: Blogpost[] = fetchState.data?.blogposts ? fetchState.data.blogposts : [];
    return (
        <Container sx={{ mt: 9 }} maxWidth="xl">
            <Grid container>
                {blogposts.map((blogpost: Blogpost) => {
                    return (
                        <Grid item xs={12}>
                            <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
                                <Typography>{blogpost.name}</Typography>
                                <img src={blogpost.image} width={100} />
                                <h6>{blogpost.tags.join(',')}</h6>
                            </Paper>
                        </Grid>

                    );
                })}
            </Grid>
        </Container>
    );
}

export default HomePage;