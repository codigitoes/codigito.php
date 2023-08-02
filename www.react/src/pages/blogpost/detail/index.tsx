import { Container, Grid } from "@mui/material"
import React from "react";
import HomeHeader from "../../../components/common/PublicHeader";
import useFetch from "../../../hooks/useFetch";

const endpoint:string = 'http://localhost:8001/api/client/web/detail/93d52a3a-bffe-41a6-a52d-455336219ba0';
const BlogpostDetailPage:React.FC =()=>{

    const fetchState = useFetch<unknown>(endpoint);
    if (fetchState.state === 'loading' || fetchState.state === 'idle'){
        return (<Container sx={{ mt:9 }} maxWidth="xl">
            <HomeHeader title='{.".} loading...' description=""/>
        </Container>);
    }

    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <Grid container>
                <h1>Hola</h1>
            </Grid>
        </Container>
    );
}

export default BlogpostDetailPage;