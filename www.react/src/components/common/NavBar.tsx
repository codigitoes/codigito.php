import { AppBar, Box, Button, Container, Grid, Stack, Toolbar, Typography } from "@mui/material";

const NavBar:React.FC<unknown> = () => {
    return (
        <Box sx={{
            flexGrow: 1
        }}>
            <AppBar>
                <Toolbar>
                    <Container maxWidth='xl'>
                        <Grid container direction='row' justifyContent='space-between' alignItems='center'>
                            <Grid item>
                                <Typography variant="h6">{'{.".}'}</Typography>
                            </Grid>
                            <Grid item>
                                <Stack direction="row" spacing={2}>
                                    <Button variant="outlined">
                                        <Typography>Inicio</Typography>
                                    </Button>
                                    <Button variant="outlined">
                                        <Typography>Videos</Typography>
                                    </Button>
                                </Stack>
                            </Grid>
                        </Grid>
                    </Container>
                </Toolbar>
            </AppBar>
        </Box>
    );
}

export default NavBar;