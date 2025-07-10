# ========== ETAPA DE CONSTRUÇÃO ==========
FROM node:18 as builder

# 1. Copia TUDO para o container
WORKDIR /app
COPY . .

# 2. Instala e builda o frontend
RUN cd frontend && npm install && npm run build

# 3. Instala o backend
RUN cd backend && npm install

# ========== ETAPA FINAL ==========
FROM node:18
WORKDIR /app

# Copia apenas o necessário
COPY --from=builder /app/backend ./backend
COPY --from=builder /app/frontend/build ./frontend/build

# Instala o serve para o frontend
RUN npm install -g serve

# Portas
EXPOSE 10000  # Backend
EXPOSE 3000   # Frontend

# Comando de inicialização
CMD ["sh", "-c", "node backend/index.js & serve -s frontend/build -l 3000"]