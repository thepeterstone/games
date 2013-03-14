import sys, pygame

class Go(object):
    def __init__(self, size):
        self.board = Board(size)
        self.screen = View(640, 480)
        self.next_move = 'black'

    def run(self):
        self.intro()
        self.main_loop()
        self.outro()

    def intro(self):
        return
        self.screen.paint_intro()
        while 1:
            for event in pygame.event.get():
                if event.type == pygame.KEYDOWN or event.type == pygame.MOUSEBUTTONDOWN: return
                self.menu_event(event)

            pygame.display.update()
            pygame.time.wait(5)

    def main_loop(self):
        while 1:
            for event in pygame.event.get():
                if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE): return
                else: self.handle_event(event)

            self.screen.paint_background(self.next_move)
            self.screen.paint_stones(self.board)

            pygame.display.update()
            pygame.time.wait(5)

    def outro(self):
        self.screen.paint_outro()
        while 1:
            for event in pygame.event.get():
                if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE): sys.exit()
            pygame.time.wait(5)

    def menu_event(self, event):
        pass

    def handle_event(self, event):
        if event.type == pygame.MOUSEBUTTONDOWN:
            try:
                x,y = self.screen.coordinates(pygame.mouse.get_pos())
                if self.board.place_piece(x, y, self.next_move):
                    self.next_move = 'black' if self.next_move=='white' else 'white'
            except TypeError, e:
                pass

class Board:
    def __init__(self, size):
        self.stones = self.init_stones(size)

    def init_stones(self, size):
        return  [[0 for col in range(size)] for row in range(size)]

    def place_piece(self, x, y, color):
        if self.valid_position(x, y, color):
            self.stones[x][y] = color
            return True
        else:
            return False

    def valid_position(self, x, y, color):
        if self.stones[x][y] != 0: return False



class View(object):
    """Display a Board"""
    def __init__(self, width, height):
        self.surface = pygame.display.set_mode((width, height))
        self.bg_color = 174,174,192
        bg_offset = width - height
        if bg_offset > 0:
            board_size = (height, height)
            self.offset = (5 + bg_offset, 5)
        else:
            sys.stderr()

        self.spacing = 25

        self.board = pygame.transform.scale(pygame.image.load("resources/board.png").convert(), board_size)
        self.piece = {
            'black': pygame.transform.scale(pygame.image.load("resources/black-stone.gif"), (board_size[0] / 24, board_size[1] / 24)),
            'white': pygame.transform.scale(pygame.image.load("resources/white-stone.gif"), (board_size[0] / 24, board_size[1] / 24))
        }

    def paint_intro(self):
        pass

    def paint_background(self, next):
        x_offset, y_offset = self.offset
        self.surface.fill(self.bg_color)
        self.surface.blit(self.board, (x_offset - 5, y_offset - 5))
        font = pygame.font.Font(None, 22)

        title = font.render("Go", 0, (62,62,62))
        titlepos = title.get_rect()
        titlepos.centerx = x_offset / 2
        self.surface.blit(title, titlepos)

        text = font.render("Next:", 0, (0,0,0))
        self.surface.blit(text, (2,44))
        font = pygame.font.Font(None, 42)
        self.surface.blit(self.piece[next], (40, 40))

    def paint_stones(self, board):
        x_offset, y_offset = self.offset
        x = 0;
        for row in board.stones:
            y = 0;
            for position in row:
                if position in self.piece: self.surface.blit(self.piece[position], (x * self.spacing + x_offset, y * self.spacing + y_offset))
                y += 1
            x += 1

    def paint_outro(self):
        self.surface.fill(self.bg_color)
        font = pygame.font.Font(None, 22)
        title = font.render("Press Esc to quit!", 0, (62,62,62))
        titlepos = title.get_rect()
        titlepos.centerx = self.offset[0] / 2
        self.surface.blit(title, titlepos)

    def coordinates(self, pos):
        x_offset, y_offset = self.offset
        x = (pos[0] - x_offset)
        y = (pos[1] - y_offset)

        tolerance = 20
        if x % self.spacing < tolerance and y % self.spacing < tolerance:
            return (x / self.spacing, y / self.spacing)
        else: return None
                




if __name__=='__main__':
    pygame.init()
    game = Go(24)
    game.run()
