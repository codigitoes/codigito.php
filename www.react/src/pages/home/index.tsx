import { Container, Grid } from "@mui/material"
import React from "react";
import HomeHeader from "./HomeHeader";
import fixture from './fixture.json';
import Blogpost from "../../types/Blogpost";

//const endpoint:string = 'http://localhost:8001/api/client/web/list';
const HomePage:React.FC =()=>{
    // const fetchState = useFetch<{
    //     blogposts:Blogpost[]
    // }>(endpoint);
    // if (fetchState.state === 'loading' || fetchState.state === 'idle'){
    //     return (<Container sx={{ mt:9 }} maxWidth="xl">
    //         <HomeHeader title='{.".} loading...' description=""/>
    //     </Container>);
    // }

    // const blogposts:Blogpost[] = fetchState.data?.blogposts ? fetchState.data.blogposts : [];
    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <HomeHeader title='codigito.es' description='el camino del test'/>
            <ul>
            {fixture.blogposts.map((blogpost:Blogpost) => {
                return (
                    <li key={blogpost.id}>
                        <hr/>
                        <h4>{blogpost.name}</h4>
                        <img src={blogpost.image} width={100} />
                        <h6>{blogpost.tags.join(',')}</h6>
                    </li>
                );
            })}
            </ul>
            <hr/>
        </Container>
    );
}

export default HomePage;