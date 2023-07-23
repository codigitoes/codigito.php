import { Button, Container } from "@mui/material"
import React from "react";

const HomePage:React.FC<unknown> =()=>{
    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <Button fullWidth variant="contained">
                Home
            </Button>
        </Container>
    );
}

export default HomePage;