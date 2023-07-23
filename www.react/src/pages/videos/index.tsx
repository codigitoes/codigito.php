import { Button, Container } from "@mui/material"
import React from "react";

const VideosPage:React.FC<unknown> =()=>{
    return (
        <Container sx={{ mt:9 }} maxWidth="xl">
            <Button fullWidth variant="contained">
                Videos
            </Button>
        </Container>
    );
}

export default VideosPage;