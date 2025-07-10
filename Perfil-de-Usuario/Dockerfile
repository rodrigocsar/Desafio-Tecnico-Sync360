# Backend
FROM node:18 as backend
WORKDIR /app
COPY backend/package*.json ./backend/
RUN cd backend && npm install
COPY backend ./backend/

# Frontend
FROM node:18 as frontend
WORKDIR /app
COPY frontend/package*.json ./frontend/
RUN cd frontend && npm install
COPY frontend ./frontend/
RUN cd frontend && npm run build

# Imagem final
FROM node:18
WORKDIR /app
COPY --from=backend /app/backend ./backend
COPY --from=frontend /app/frontend/build ./frontend/build

# Instala o serve para hospedar o frontend
RUN npm install -g serve

CMD ["sh", "-c", "node backend/index.js & serve -s frontend/build -l 3000"]