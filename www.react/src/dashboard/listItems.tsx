import * as React from 'react';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import PeopleIcon from '@mui/icons-material/People';
import { HomeOutlined, PlayCircle } from '@mui/icons-material';

export const mainListItems = (
  <React.Fragment>
    <ListItemButton component='a' href='/'>
      <ListItemIcon>
        <HomeOutlined />
      </ListItemIcon>
      <ListItemText primary="Dashboard" />
    </ListItemButton>
    <ListItemButton component='a' href='/blog'>
      <ListItemIcon>
        <PlayCircle />
      </ListItemIcon>
      <ListItemText primary="Blog" />
    </ListItemButton>
    <ListItemButton component='a' href='/contacto'>
      <ListItemIcon>
        <PeopleIcon />
      </ListItemIcon>
      <ListItemText primary="Contacto" />
    </ListItemButton>
  </React.Fragment>
);