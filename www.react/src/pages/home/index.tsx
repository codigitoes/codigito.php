import { Container } from "@mui/material"
import React from "react";
import HomeHeader from "./HomeHeader";

const HomePage:React.FC =()=>{


    React.useEffect(()=>{}, []);

    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <HomeHeader title='codigito.es' description='el camino del test'/>
        </Container>
    );
}

export default HomePage;