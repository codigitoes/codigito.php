import { Container, Grid, Paper } from "@mui/material"
import React from "react";
import HomeHeader from "../../components/common/PublicHeader";
import Blogpost from "../../types/Blogpost";
import useFetch from "../../hooks/useFetch";
import { useNavigate } from "react-router-dom";

const endpoint:string = 'http://localhost:8001/api/client/web/list';
const HomePage:React.FC =()=>{
    const navigate = useNavigate();

    const fetchState = useFetch<{
        blogposts:Blogpost[]
    }>(endpoint);
    if (fetchState.state === 'loading' || fetchState.state === 'idle'){
        return (<Container sx={{ mt:9 }} maxWidth="xl">
            <HomeHeader title='{.".} loading...' description=""/>
        </Container>);
    }

    const blogposts:Blogpost[] = fetchState.data?.blogposts ? fetchState.data.blogposts : [];
    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <Grid container>
            {blogposts.map((blogpost:Blogpost) => {
                return (
                    <Grid item xs={12} sm={6} lg={4} key={blogpost.id} onClick={()=>navigate(`/blogpost/${blogpost.id}`)}>
                        <Paper  sx={{m:1}}>
                            <h5>{blogpost.name}</h5>
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