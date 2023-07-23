import { Container } from "@mui/material"
import React from "react";
import Header from "../../components/common/Header";

const HomePage:React.FC<undefined> =()=>{
    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <Header title='codigito.es' description='el camino del test'/>
        </Container>
    );
}

export default HomePage;