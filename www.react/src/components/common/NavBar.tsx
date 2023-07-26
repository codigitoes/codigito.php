import { AppBar, Box, Button, Container, Grid, Stack, Toolbar, Typography } from "@mui/material";
import { useNavigate } from "react-router-dom";

const NavBar:React.FC<unknown> = () => {
    const navigate = useNavigate();

    return (
        <Box sx={{
            flexGrow: 1
        }}>
            <AppBar>
                <Toolbar>
                    <Container maxWidth='xl'>
                        <Grid container direction='row' justifyContent='space-between' alignItems='center'>
                            <Grid item>
                                <Button onClick={()=>{navigate('/')}}>
                                    <Typography variant="h6">{'{.".}'}</Typography>
                                </Button>
                            </Grid>
                            <Grid item>
                                <Stack direction="row" spacing={2}>
                                    <Button variant="outlined" onClick={()=>{navigate('/')}}>
                                        <Typography>videos</Typography>
                                    </Button>
                                </Stack>
                            </Grid>
                        </Grid>
                    </Container>
                </Toolbar>
            </AppBar>
            <Toolbar/>
        </Box>
    );
}

export default NavBar;