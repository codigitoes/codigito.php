import { Box, Button, Container, Grid, Paper, TextField, Typography } from "@mui/material"
import React from "react";
import { useNavigate } from "react-router-dom";

type LoginType = {
    email: string;
    password: string;
}

const LoginPage:React.FC<unknown> =()=>{
    const navigate = useNavigate();

    const [formData,setFormData] = React.useState<LoginType>({
        email: '',
        password: ''
    })

    const inputChanged = (event:React.ChangeEvent<HTMLInputElement>) => {
        setFormData({
            ...formData,
            [event.target.name]: [event.target.value]
        });
    }
    const formSubmitted = (event:React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        navigate('/');
    }

    return (
        <Container maxWidth="sm">
            <Button onClick={()=>{ navigate('/') }}>volver a inicio</Button>
            <Grid container direction="column" alignItems="center" justifyContent="center" sx={{ minHeight: "100vh" }}>
                <Grid item>
                    <Paper sx={{
                        padding:"1.2em",
                        borderRadius: "0.5em"
                    }}>                            
                        <Typography variant="h4">Iniciar Sesión</Typography>
                        <Box component="form" onSubmit={(event:React.FormEvent<HTMLFormElement>)=>formSubmitted(event)}>
                            <TextField
                                fullWidth 
                                required 
                                label='Nombre de usuario' 
                                name="email" 
                                type='email' 
                                sx={{ mt:2,mb:1.5 }} 
                                value={formData.email} 
                                onChange={(event:React.ChangeEvent<HTMLInputElement>)=>inputChanged(event)}></TextField>
                            <TextField
                                fullWidth 
                                required 
                                label='Clave de acceso' 
                                name="password" 
                                type='password' 
                                sx={{ mt:2,mb:1.5 }} 
                                value={formData.password} 
                                onChange={(event:React.ChangeEvent<HTMLInputElement>)=>inputChanged(event)}></TextField>
                            <Button fullWidth type="submit" variant="contained" sx={{ mt:1.5,mb:1.5 }}>Iniciar Sesión</Button>
                        </Box>
                    </Paper>
                </Grid>
            </Grid>
        </Container>
    );
}

export default LoginPage;