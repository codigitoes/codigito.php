import LockOutlinedIcon from '@mui/icons-material/LockClockOutlined';
import Avatar from '@mui/material/Avatar';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Container from '@mui/material/Container';
import CssBaseline from '@mui/material/CssBaseline';
import Grid from '@mui/material/Grid';
import Link from '@mui/material/Link';
import TextField from '@mui/material/TextField';
import Typography from '@mui/material/Typography';
import axios from 'axios';
import { NavLink, useNavigate } from 'react-router-dom';
import { useUserContext, useUserToggleContext } from '../../components/UserProvider';
import { useEffect } from 'react';

const endpoint: string = 'http://localhost:8001/api/login_check';

const LoginPage = () => {
    const navigate = useNavigate();
    const setToken = useUserToggleContext();
    const token = useUserContext();

    useEffect(() => {
        if (token !== null) {
            setToken(null);
            navigate('/login');
        }
    });

    const handleSubmit = async (event) => {
        event.preventDefault();
        const formData = new FormData(event.currentTarget);
        const email = formData.get('email');
        const password = formData.get('password');

        try {
            const { data } = await axios.post(
                endpoint,
                {
                    email,
                    password,
                }
            );
            if (data.token) {
                setToken(data.token);
                navigate('/');

                return;
            }
            alert('unauthorized');
        } catch (error) {
            alert('unauthorized');
        }
    };

    return (
        <Container component='main' maxWidth='xs'>
            <CssBaseline />
            <Box
                sx={{
                    marginTop: 8,
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                }}
            >
                <Avatar sx={{ m: 1, bgcolor: 'primary.main' }}>
                    <LockOutlinedIcon />
                </Avatar>
                <Typography component='h1' variant='h5'>
                    Sign in
                </Typography>
                <Box
                    component='form'
                    onSubmit={handleSubmit}
                    noValidate
                    sx={{ mt: 1 }}
                >
                    <TextField
                        margin='normal'
                        required
                        fullWidth
                        id='email'
                        label='Email Address'
                        name='email'
                        autoComplete='email'
                        autoFocus
                        value={'markitosco@gmail.com'}
                    />
                    <TextField
                        margin='normal'
                        required
                        fullWidth
                        name='password'
                        label='Password'
                        type='password'
                        id='password'
                        autoComplete='current-password'
                        value={'markitosco@gmail.com'}
                    />
                    <Button
                        type='submit'
                        fullWidth
                        variant='contained'
                        sx={{ mt: 3, mb: 2 }}
                    >
                        Sign In
                    </Button>
                    <Grid container>
                        <Grid item>
                            <Link
                                component={NavLink}
                                to='/register'
                                variant='body1'
                            >
                                {"Don't have an account? Sign Up"}
                            </Link>
                        </Grid>
                    </Grid>
                </Box>
            </Box>
        </Container>
    );
};

export default LoginPage;
